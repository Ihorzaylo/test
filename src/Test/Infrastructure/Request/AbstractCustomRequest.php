<?php
declare(strict_types=1);

namespace Test\Infrastructure\Request;

use Symfony\Component\HttpFoundation\Request;


abstract class AbstractCustomRequest implements CustomRequestInterface
{
    /** @var mixed[] */
    protected $validatableData;

    /** @var mixed[] */
    private $unexpectedParams;

    /** @var mixed[] */
    private $requestHeaders;

    public function populate(Request $request): void
    {
        $this->validatableData = [];
        $this->unexpectedParams = [];
        $this->mapRequestFields($request);
    }

    /**
     * @param mixed $params
     *
     * @return mixed
     */
    public function __call(string $method, $params)
    {
        $var = lcfirst(substr($method, 3));

        if (strncasecmp($method, 'get', 3) === 0) {
            return $this->{$var};
        }

        if (strncasecmp($method, 'set', 3) !== 0) {
            return;
        }

        $this->{$var} = $params[0];
    }

    /** @return mixed[] */
    public function getRequestHeaders(): array
    {
        return $this->requestHeaders ?? [];
    }

    public function getRequestHeader(string $key): ?string
    {
        return $this->getRequestHeaders()[strtolower($key)][0] ?? null;
    }

    private function mapRequestFields(Request $request): void
    {
        $this->requestHeaders = $request->headers->all();

        $params = [];

        if ($request->isMethod('POST')) {
            $content = $request->getContent();

            if (strlen((string)$content)) {
                $contentXml = new \SimpleXMLElement($content);
                $params = [];
                foreach ($contentXml->attributes() as $key => $value) {
                    $params[$key] = (string)$value;
                }
            }
        }

        $params = array_merge($params, $request->attributes->all());
        $params = array_filter(
            $params,
            static function ($key) {
                return $key !== '_route' &&
                    $key !== '_controller' &&
                    $key !== '_route_params' &&
                    $key !== '_firewall_context' &&
                    $key !== '_security' &&
                    $key !== 'media_type';
            },
            ARRAY_FILTER_USE_KEY
        );

        $properties = [];

        foreach ($this as $property => $value) {
            $properties[] = $property;

            if (!isset($params[$property])) {
                continue;
            }

            $this->{$property} = $params[$property];
            $this->validatableData[$property] = $params[$property];
        }

        foreach ($params as $param => $value) {
            if (in_array($param, $properties)) {
                continue;
            }

            $this->unexpectedParams[] = $param;
        }
    }

    /** @return mixed[] */
    public function getUnexpectedParams(): array
    {
        return $this->unexpectedParams;
    }

    /** @return mixed[] */
    public function getValidatableData(): array
    {
        return $this->validatableData;
    }
}
