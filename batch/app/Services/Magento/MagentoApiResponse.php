<?php

namespace App\Services\Magento;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class RainForestApiResponse
 * @package App\Services\Magento
 */
class MagentoApiResponse implements ResponseInterface
{
    /** @var ResponseInterface $response */
    private $response;

    /**
     * @var array|null
     */
    private $contents;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        if ($response->getStatusCode() === 200) {
            $this->contents = json_decode((string)$this->response->getBody(), true);
        }
    }

    /**
     * @return array|null
     */
    public function getContents(): ?array
    {
        return $this->contents;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->getStatusCode() === 200;
    }

    /**
     * @inheritDoc
     */
    public function getProtocolVersion()
    {
        return $this->response->getProtocolVersion();
    }

    /**
     * @inheritDoc
     */
    public function withProtocolVersion($version): ResponseInterface
    {
        return $this->response->withProtocolVersion($version);
    }

    /**
     * @inheritDoc
     */
    public function getHeaders()
    {
        return $this->response->getHeaders();
    }

    /**
     * @inheritDoc
     */
    public function hasHeader($name)
    {
        return $this->response->hasHeader($name);
    }

    /**
     * @inheritDoc
     */
    public function getHeader($name)
    {
        return $this->response->getHeader($name);
    }

    /**
     * @inheritDoc
     */
    public function getHeaderLine($name)
    {
        return $this->response->getHeaderLine($name);
    }

    /**
     * @inheritDoc
     */
    public function withHeader($name, $value): ResponseInterface
    {
        return $this->response->withHeader($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function withAddedHeader($name, $value): ResponseInterface
    {
        return $this->response->withAddedHeader($name, $value);
    }

    /**
     * @inheritDoc
     */
    public function withoutHeader($name): ResponseInterface
    {
        return $this->response->withoutHeader($name);
    }

    /**
     * @inheritDoc
     */
    public function getBody()
    {
        return $this->response->getBody();
    }

    /**
     * @inheritDoc
     */
    public function withBody(StreamInterface $body): ResponseInterface
    {
        return $this->response->withBody($body);
    }

    /**
     * @inheritDoc
     */
    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }

    /**
     *  @return ResponseInterface
     */
    public function withStatus($code, $reasonPhrase = ''): ResponseInterface
    {
        return $this->response->withStatus($code, $reasonPhrase);
    }

    /**
     * @inheritDoc
     */
    public function getReasonPhrase()
    {
        return $this->response->getReasonPhrase();
    }
}
