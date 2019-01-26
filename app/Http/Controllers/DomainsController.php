<?php

namespace App\Http\Controllers;

use App\Domain;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use function GuzzleHttp\Psr7\parse_header;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use DiDom\Document;

class DomainsController extends Controller
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        $domains = DB::table('domains')->orderBy('id', 'desc')->paginate(10);
        return view('domain.index', ['domains' => $domains]);
    }

    public function show($id)
    {
        $domain = Domain::findOrFail($id);
        return view('domain.show', ['domain' => $domain]);
    }

    public function store(Request $request)
    {
        $rules = ['name' => 'required|url'];
        $name = $request->get('name');

        try {
            $this->validate($request, $rules);
        } catch (ValidationException $exception) {
            return response(view("index", [
                'errors' => [$exception->getMessage()],
                'name' => $name]), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $domainName = $request->get('name');
        $opt = [
            'timeout' => 5,
            'connect_timeout' => 5,
            'allow_redirects' => true,
        ];
//        $client = new Client($opt);

        $domain = new Domain();
        $domain->name = $domainName;
        $domain->status_code = 0;
        $domain->content_length = 0;

        try {
            $requestResult = $this->client->get($domainName, $opt);

            $header = function ($name) use ($requestResult) {
                if ($requestResult->hasHeader($name)) {
                    return $requestResult->getHeader($name)[0];
                }
                return null;
            };

            $body = $requestResult->getBody()->getContents();
            $statusCode = $requestResult->getStatusCode();

            $contentLength = $header('Content-Length');
            if (empty($contentLength)) {
                $contentType = $header('Content-Type');
                if (empty($contentType)) {
                    $contentLength = mb_strlen($body);
                } else {
                    $parseCharset = parse_header($contentType);
                    $charset = ($parseCharset[0]['charset']) ? $parseCharset[0]['charset'] : 'UTF-8';
                    $encodingBody = mb_convert_encoding($body, 'UTF-8', $charset);
                    $contentLength = mb_strlen($encodingBody);
                }
            }

            $document = new Document($body);
            $domain->h1 = $document->first('h1::text()');
            $domain->keywords = $document->first('meta[name=keywords]::attr(content)');
            $domain->description = $document->first('meta[name=description]::attr(content)');

            $domain->content_length = $contentLength;
            $domain->status_code = $statusCode;
            $domain->body = $body;
        } catch (RequestException $exception) {
            $response = $exception->getResponse();
            if ($response) {
                $domain->status_code = $response->getStatusCode();
                $domain->body = $response->getBody()->getContents();
                $domain->content_length = mb_strlen($domain->body);
            }
        } catch (\Exception $exception) {
            $error[] = $exception->getMessage();
            $error[] = "Response status code {$exception->getCode()}";
            return response(view("index", [
                'errors' => $error,
                'name' => $name]), Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $domain->saveOrFail();
        $id = $domain->id;
        return redirect()->route('domains.show', ['id' => $id]);
    }

    public function destroy($id)
    {
        $domain = Domain::findOrFail($id);
        $domain->delete();
        return redirect()->route('domains.index');
    }
}
