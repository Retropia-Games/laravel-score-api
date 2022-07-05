<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Helpers\Encryption;

class DecryptTest extends TestCase
{
    const ENCRYPTED_DATA_PROPER = 'hLrWNPU5zHne5wHTf/8/X0JHZ5lSRSHLflO7QaP27LuLp3SpROAz4f+/7MkYEi6c+0dl1GeR9adi3JTxXyutYg==';
    const KEY = '0123456789abcdef0123456789abcdef';
    const IV = 'abcdef9876543210abcdef9876543210';

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_decrypt()
    {
        $decrypted = trim(Encryption::decrypt(self::ENCRYPTED_DATA_PROPER, self::KEY, self::IV));
        $json = json_decode($decrypted, true);

        $this->assertEqualsCanonicalizing([
            "nickname" => "fedek6",
            "score" => "10",
            "source" => "localhost"
        ], $json);
    }
}
