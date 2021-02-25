<?php

declare(strict_types=1);

namespace App\Tests\exporter\application\services\converter\inputJsonSchemaV1;

use App\exporter\application\services\converter\inputJsonSchemaV1\jsonToCvPartConverters\CoverLetterConverter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CoverLetterConverterTest extends KernelTestCase
{
    private CoverLetterConverter $converter;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->converter = self::$kernel->getContainer()->get(CoverLetterConverter::class);
    }

    public function testConversion(): void
    {
        $inputJson = file_get_contents('tests/exporter/application/services/converter/inputJsonSchemaV1/input-data/cv-v1.json');
        $jsonObject = json_decode($inputJson);
        $coverLetter = $this->converter->convert($jsonObject);
        $this->assertEquals($jsonObject->coverLetter->text, $coverLetter->getText());
    }
}
