<?php
declare(strict_types=1);

namespace Test\Infrastructure\Response;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class XMLResponse
 * @package Test\Infrastructure\Response
 */
class XMLResponse extends Response
{
    /**
     *
     */
    private const  STATUS_OK = 'OK';
    /**
     *
     */
    private const  STATUS_ERROR = 'ERROR';

    /**
     * XMLResponse constructor.
     *
     * @param string $status
     * @param string $msg
     * @param int    $code
     */
    public function __construct(string $status, string $msg, int $code)
    {
        parent::__construct(
            sprintf(
                '<?xml version="1.0"?><result status="%s"%s></result>',
                $status,
                $msg ? sprintf(' msg="%s"', $msg) : ''
            ),
            200,
            [
                'Content-Type' => 'text/xml',
            ]
        );
    }

    /**
     * @param string   $msg
     * @param int|null $code
     *
     * @return static
     */
    public static function success(string $msg = '', ?int $code = Response::HTTP_OK): self
    {
        return new self(
            self::STATUS_OK,
            $msg,
            $code
        );
    }

    /**
     * @param string $msg
     * @param int    $code
     *
     * @return static
     */
    public static function error(
        string $msg = 'internal server error',
        int $code = Response::HTTP_INTERNAL_SERVER_ERROR
    ): self {
        return new self(
            self::STATUS_ERROR,
            $msg,
            $code
        );
    }
}
