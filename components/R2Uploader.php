<?php

namespace app\components;

use Aws\S3\S3Client;
use Throwable;
use Yii;
use yii\base\Component;

/**
 *
 * @property-read S3Client $client
 */
class R2Uploader extends Component
{
    public string $accessKey;
    public string $secretKey;
    public string $bucket;
    public string $endpoint;
    public string $region = 'auto'; // vagy 'us-east-1'

    public function upload(string $localPath, string $remoteKey, string $contentType = 'image/webp'): string
    {
        $client = $this->getClient();
        $client->putObject([
            'Bucket'      => $this->bucket,
            'Key'         => $remoteKey,
            'SourceFile'  => $localPath,
            'ContentType' => $contentType,
            'ACL'         => 'public-read',
        ]);

        return "$this->endpoint/$this->bucket/$remoteKey";
    }

    private function getClient(): S3Client
    {
        $client = new S3Client([
            'credentials' => [
                'key'    => $this->accessKey,
                'secret' => $this->secretKey,
            ],
            'region'                  => $this->region,
            'version'                 => 'latest',
            'endpoint'                => $this->endpoint,
            'use_path_style_endpoint' => true,
        ]);

        $client->getHandlerList()->appendInit(function ($handler) {
            return function ($command, $request = null) use ($handler) {
                if ($request?->hasHeader('x-amz-checksum-crc32')) {
                    $request = $request->withoutHeader('x-amz-checksum-crc32');
                }
                if ($request?->hasHeader('x-amz-sdk-checksum-algorithm')) {
                    $request = $request->withoutHeader('x-amz-sdk-checksum-algorithm');
                }
                return $handler($command, $request);
            };
        }, 'remove_cf_invalid_headers');

        return $client;
    }

    public function delete(string $remoteKey): bool
    {
        $client = $this->getClient();
        try {
            $client->deleteObject([
                'Bucket' => $this->bucket,
                'Key'    => $remoteKey,
            ]);
            return true;
        } catch (Throwable $e) {
            Yii::error("R2 törlési hiba: " . $e->getMessage() . " Kulcs: " . $remoteKey);
            return false;
        }
    }
}
