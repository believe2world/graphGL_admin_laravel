<?php

declare(strict_types = 1);
namespace Rebing\GraphQL;

use GraphQL\Server\OperationParams as BaseOperationParams;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Laragraph\Utils\RequestParser;
use Rebing\GraphQL\Support\OperationParams;

class GraphQLController extends Controller
{
    public function query(Request $request, RequestParser $parser): JsonResponse
    {
        $routePrefix = config('graphql.route.prefix', 'graphql');
        $schemaName = $this->findSchemaNameInRequest($request, "$routePrefix/") ?? config('graphql.default_schema', 'default');

        $operations = $parser->parseRequest($request);

        $headers = config('graphql.headers', []);
        $jsonOptions = config('graphql.json_encoding_options', 0);

        $isBatch = is_array($operations);

        $supportsBatching = config('graphql.batching.enable', true);

        if ($isBatch && !$supportsBatching) {
            $data = $this->createBatchingNotSupportedResponse($request->input());

            return response()->json($data, 200, $headers, $jsonOptions);
        }

        // TODO: inject?
        /** @var GraphQL $graphql */
        $graphql = Container::getInstance()->make('graphql');

        $data = Helpers::applyEach(
            function (BaseOperationParams $baseOperationParams) use ($schemaName, $graphql): array {
                $operationParams = OperationParams::fromBaseOperationParams($baseOperationParams);

                return $graphql->query($schemaName, $operationParams);
            },
            $operations
        );

        return response()->json($data, 200, $headers, $jsonOptions);
    }

    public function graphiql(Request $request): View
    {
        $routePrefix = config('graphql.graphiql.prefix', 'graphiql');
        $schemaName = $this->findSchemaNameInRequest($request, "$routePrefix/");

        $graphqlPath = '/' . config('graphql.route.prefix', 'graphql');

        if ($schemaName) {
            $graphqlPath .= '/' . $schemaName;
        }

        $view = config('graphql.graphiql.view', 'graphql::graphiql');

        return view($view, [
            'graphqlPath' => $graphqlPath,
            'schema' => $schemaName,
        ]);
    }

    /**
     * In case batching is not supported, send an error back for each batch
     * (with a hardcoded limit of 100).
     *
     * The returned format still matches the GraphQL specs
     *
     * @param array<string,mixed> $input
     * @return array<array{errors:array<array{message:string}>}>
     */
    protected function createBatchingNotSupportedResponse(array $input): array
    {
        $count = min(count($input), 100);

        $data = [];

        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'errors' => [
                    [
                        'message' => 'Batch request received but batching is not supported',
                    ],
                ],
            ];
        }

        return $data;
    }

    protected function findSchemaNameInRequest(Request $request, string $routePrefix): ?string
    {
        $path = $request->path();

        if (!Str::startsWith($path, $routePrefix)) {
            return null;
        }

        return Str::after($path, $routePrefix);
    }
}
