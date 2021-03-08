<?php

declare(strict_types=1);

namespace App\Tests\core\application\services\validators;

use App\core\application\services\validators\JsonSchemaValidator;
use App\Tests\exporter\application\services\exporter\traits\ExporterHelperTrait;
use Exception;
use JsonSchema\Exception\InvalidSchemaException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JsonSchemaValidatorTest extends KernelTestCase
{
    use ExporterHelperTrait;

    private string $inputJson;

    private string $schemaPath;

    private JsonSchemaValidator $validator;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->validator = self::$kernel->getContainer()->get(JsonSchemaValidator::class);

        $this->schemaPath = self::$kernel->getContainer()->getParameter('cv_schema_v1');
    }

    public function testValidJsons(): void
    {
        $this->assertValidJson($this->getInputJson_cv1());
        $this->assertValidJson($this->getInputJson_cv2());
    }

    private function assertValidJson(string $json): void
    {
        try{
            $exceptionThrown = false;
            $this->validator->validate($json, $this->schemaPath);
        } catch (Exception $e) {
            $exceptionThrown = true;
        }

        $this->assertFalse($exceptionThrown);
    }

    public function testInvalidJson_MissingPersonalDetails(): void
    {
        $jsonObject = $this->getInputJsonArray_cv1();
        unset($jsonObject->personalDetails);
        $invalidJson = json_encode($jsonObject);
        $this->expectException(InvalidSchemaException::class);
        try {
            $this->validator->validate($invalidJson, $this->schemaPath);
        } catch (Exception $e) {
            $this->assertTrue(str_contains($e->getMessage(), 'personalDetails'));
            throw $e;
        }
    }

    public function testInvalidJson_MissingCoverLetter(): void
    {
        $jsonObject = $this->getInputJsonArray_cv1();
        unset($jsonObject->coverLetter);
        $invalidJson = json_encode($jsonObject);
        $this->expectException(InvalidSchemaException::class);
        try {
            $this->validator->validate($invalidJson, $this->schemaPath);
        } catch (Exception $e) {
            $this->assertTrue(str_contains($e->getMessage(), 'coverLetter'));
            throw $e;
        }

    }

    public function testInvalidJson_MissingWorkExperiences(): void
    {
        $jsonObject = $this->getInputJsonArray_cv1();
        unset($jsonObject->workExperiences);
        $invalidJson = json_encode($jsonObject);
        $this->expectException(InvalidSchemaException::class);
        try {
            $this->validator->validate($invalidJson, $this->schemaPath);
        } catch (Exception $e) {
            $this->assertTrue(str_contains($e->getMessage(), 'workExperiences'));
            throw $e;
        }

    }

    public function testInvalidJson_MissingAcademicExperiences(): void
    {
        $jsonObject = $this->getInputJsonArray_cv1();
        unset($jsonObject->academicExperiences);
        $invalidJson = json_encode($jsonObject);
        $this->expectException(InvalidSchemaException::class);
        try {
            $this->validator->validate($invalidJson, $this->schemaPath);
        } catch (Exception $e) {
            $this->assertTrue(str_contains($e->getMessage(), 'academicExperiences'));
            throw $e;
        }
    }
}
