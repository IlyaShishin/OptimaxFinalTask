<?php

use Codeception\Example;
use Codeception\Util\HttpCode;


class TriangleCheckerCest
{
    /**
     * @dataProvider myProviderFirst
     * @param ApiTester $I
     */
    public function getTriangleWithPositiveValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует позитивный сценарий, с вводом трёх целых положительных значений;
        //Ожидаем true, так как такой треугольник может существовать;
    {
        $I->sendGet('/triangle/possible?a=2&b=3&c=4');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    public function getTriangleWithZeroValues(ApiTester $I): void
        //Метод тестирует сценарий, с вводом трёх целых значений, равных нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=0&b=0&c=0');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithAIsZero(ApiTester $I): void
        //Метод тестирует сценарий, с вводом параметра 'a' равному нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=0&b=2&c=3');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithBIsZero(ApiTester $I): void
        //Метод тестирует сценарий, с вводом параметра 'b' равному нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=1&b=0&c=3');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithCIsZero(ApiTester $I): void
        //Метод тестирует сценарий, с вводом параметра 'c' равному нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=1&b=2&c=0');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithAAndBIsZero(ApiTester $I): void
        //Метод тестирует сценарий, с вводом параметрами 'a' и 'b' равными нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=0&b=0&c=3');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithAAndCIsZero(ApiTester $I): void
        //Метод тестирует сценарий, с вводом параметрами 'a' и 'c' равными нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=0&b=2&c=0');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithBAndCIsZero(ApiTester $I): void
        //Метод тестирует сценарий, с вводом параметрами 'b' и 'c' равными нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=1&b=2&c=0');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithNegativeValues(ApiTester $I): void
        //Метод тестирует сценарий, с вводом трёх целых отрицательных значений;
        //Ожидаем 'Not valid date', т.к. отрицательные значения не являются натуральными;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=-1&b=-2&c=-3');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithNotNaturalDotValues(ApiTester $I): void
        //Метод тестирует сценарий, с вводом одного не целого значения через символ '.' (точка);
        //Ожидаем 'Not valid date', т.к. не целые значения не являются натуральными;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=1&b=2&c=3.5');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithNotNaturalCommaValues(ApiTester $I): void
        //Метод тестирует сценарий, с вводом одного не целого значения через символ ',' (запятая);
        //Ожидаем 'Not valid date', т.к. не целые значения не являются натуральными;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=1&b=2&c=3,5');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithLiteralValues(ApiTester $I): void
        //Метод тестирует сценарий, с вводом буквенных значений;
        //Ожидаем 'Not valid date', т.к. буквенные значения не являются натуральными;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=a&b=b&c=c');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithTwoValues(ApiTester $I): void
        //Метод тестирует сценарий, с вводом только двух значений;
        //Ожидаем 'Not valid date', т.к. у треугольника должны быть три значения;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?b=1&c=2');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithOneValue(ApiTester $I): void
        //Метод тестирует сценарий, с вводом только одного значения;
        //Ожидаем 'Not valid date', т.к. у треугольника должны быть три значения;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?b=1');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleWithWrongParameters(ApiTester $I): void
        //Метод тестирует сценарий, с вводом неверных параметров a,h,w;
        //Ожидаем 'Not valid date', т.к. должны приниматься параметры a,b,c;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=2&h=3&w=4');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    private function myProviderFirst(): Generator
    {
        yield[
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => true]
        ];
    }

    private function myProviderSecond(): Generator
    {
        yield[
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => false]
        ];
    }

    private function myProviderThird(): Generator
    {
        yield[
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ["message" => ["error" => "Not valid date"]]
        ];
    }
}