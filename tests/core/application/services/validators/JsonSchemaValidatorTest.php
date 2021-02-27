<?php

declare(strict_types=1);

namespace App\Tests\core\application\services\validators;

use App\core\application\services\validators\JsonSchemaValidator;
use Exception;
use JsonSchema\Exception\InvalidSchemaException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class JsonSchemaValidatorTest extends KernelTestCase
{
    private string $inputJson;

    private string $schemaPath;

    private JsonSchemaValidator $validator;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->validator = self::$kernel->getContainer()->get(JsonSchemaValidator::class);

        $this->inputJson = file_get_contents(
            'tests/exporter/application/services/exporter/input-data/cv1-v1.json'
        );

        $this->schemaPath = self::$kernel->getContainer()->getParameter('cv_schema_v1');
    }

    public function testValidJson(): void
    {
        try{
            $exceptionThrown = false;
            $this->validator->validate($this->inputJson, $this->schemaPath);
        } catch (Exception $e) {
            $exceptionThrown = true;
        }

        $this->assertFalse($exceptionThrown);
    }

    public function testInvalidJson_MissingPersonalDetails(): void
    {
        $jsonObject = json_decode($this->inputJson);
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
        $jsonObject = json_decode($this->inputJson);
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
        $jsonObject = json_decode($this->inputJson);
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
        $jsonObject = json_decode($this->inputJson);
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
