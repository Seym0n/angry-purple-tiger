<?php

namespace Seymon\AngryPurpleTiger;

use PHPUnit\Framework\TestCase;

class GenerateTest extends TestCase
{
    private $generate;

    protected function setUp(): void
    {
        $this->generate = new \Seymon\AngryPurpleTiger\Generate();
    }

    public function testAnimalHashBasic()
    {
        $expectedVal = 'Rapid Grey Rattlesnake';
        $result = $this->generate->animalHash('my ugly input string');
        $this->assertEquals($expectedVal, $result);
    }

    public function testAnimalHashWithSeparator()
    {
        $expectedVal = 'Rapid-Grey-Rattlesnake';
        $result = $this->generate->animalHash('my ugly input string', 'titlecase', '-');
        $this->assertEquals($expectedVal, $result);
    }

    public function testAnimalHashLowercase()
    {
        $expectedVal = 'rapid grey rattlesnake';
        $result = $this->generate->animalHash('my ugly input string', 'lowercase');
        $this->assertEquals($expectedVal, $result);
    }

    public function testAnimalHashUppercase()
    {
        $expectedVal = 'RAPID GREY RATTLESNAKE';
        $result = $this->generate->animalHash('my ugly input string', 'uppercase');
        $this->assertEquals($expectedVal, $result);
    }

    public function testAnimalHashUnknownStyleThrowsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Unknown style');
        $this->generate->animalHash('xyz', 'garbage');
    }

    public function testCompressFunction()
    {
        $bytes = [23, 45, 234, 111, 46, 165, 33, 58, 156, 140, 91, 138, 50, 245, 103, 210];
        $expected = [145, 174, 163];

        $reflection = new \ReflectionClass($this->generate);
        $method = $reflection->getMethod('compress');
        $method->setAccessible(true);

        $result = $method->invoke($this->generate, $bytes, 3);
        $this->assertEquals($expected, $result);
    }

    public function testCompressWithFewerBytesThrowsException()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Fewer input bytes than requested output');

        $reflection = new \ReflectionClass($this->generate);
        $method = $reflection->getMethod('compress');
        $method->setAccessible(true);

        $method->invoke($this->generate, [23], 3);
    }

    public function testWordlistsCount()
    {
        $adjectives = require __DIR__ . '/../../../../src/adjectives.php';
        $colors = require __DIR__ . '/../../../../src/colors.php';
        $animals = require __DIR__ . '/../../../../src/animals.php';

        // Verify each wordlist has 256 entries
        $this->assertEquals(256, count($adjectives), "Adjectives should contain exactly 256 words");
        $this->assertEquals(256, count($colors), "Colors should contain exactly 256 words");
        $this->assertEquals(256, count($animals), "Animals should contain exactly 256 words");

        // Combine all wordlists
        $wordlist = array_merge($adjectives, $colors, $animals);

        // Verify total count
        $this->assertEquals(256 * 3, count($wordlist), "Total wordlist should contain exactly 768 words (256 * 3)");
    }
}
?>