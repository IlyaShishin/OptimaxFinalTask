<?php

class TriangleCheckerCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function getTriangleCheckPositiveValues(ApiTester $I)
        //Метод тестирует позитивный сценарий, с вводом трёх целых положительных значений;
        //Ожидаем true, так как такой треугольник может существовать;
    {
        $data = ["isPossible" => true];
        $I->sendGet('/triangle/possible?a=2&b=3&c=4');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckZeroValues(ApiTester $I)
        //Метод тестирует позитивный сценарий, с вводом трёх целых значений, равных нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=0&b=0&c=0');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckAIsZero(ApiTester $I)
        //Метод тестирует позитивный сценарий, с вводом параметра 'a' равному нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=0&b=2&c=3');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckBIsZero(ApiTester $I)
        //Метод тестирует позитивный сценарий, с вводом параметра 'b' равному нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=1&b=0&c=3');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckCIsZero(ApiTester $I)
        //Метод тестирует позитивный сценарий, с вводом параметра 'c' равному нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=1&b=2&c=0');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckAAndBIsZero(ApiTester $I)
        //Метод тестирует позитивный сценарий, с вводом параметрами 'a' и 'b' равными нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=0&b=0&c=3');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckAAndCIsZero(ApiTester $I)
        //Метод тестирует позитивный сценарий, с вводом параметрами 'a' и 'c' равными нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=0&b=2&c=0');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckBAndCIsZero(ApiTester $I)
        //Метод тестирует позитивный сценарий, с вводом параметрами 'b' и 'c' равными нулю;
        //Ожидаем false, т.к. треугольник не может существовать с нулевыми сторонами;
    {
        $data = ["isPossible" => false];
        $I->sendGet('/triangle/possible?a=1&b=2&c=0');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckNegativeValues(ApiTester $I)
        //Метод тестирует негативный сценарий, с вводом трёх целых отрицательных значений;
        //Ожидаем 'Not valid date', т.к. отрицательные значения не являются натуральными;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=-1&b=-2&c=-3');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckNotNaturalDotValues(ApiTester $I)
        //Метод тестирует негативный сценарий, с вводом одного не целого значения через символ '.' (точка);
        //Ожидаем 'Not valid date', т.к. не целые значения не являются натуральными;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=1&b=2&c=3.5');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckNotNaturalCommaValues(ApiTester $I)
        //Метод тестирует негативный сценарий, с вводом одного не целого значения через символ ',' (запятая);
        //Ожидаем 'Not valid date', т.к. не целые значения не являются натуральными;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=1&b=2&c=3,5');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckLiteralValues(ApiTester $I)
        //Метод тестирует негативный сценарий, с вводом буквенных значений;
        //Ожидаем 'Not valid date', т.к. буквенные значения не являются натуральными;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=a&b=b&c=c');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckTwoValues(ApiTester $I)
        //Метод тестирует негативный сценарий, с вводом только двух значений;
        //Ожидаем 'Not valid date', т.к. у треугольника должны быть три значения;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?b=1&c=2');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckOneValue(ApiTester $I)
        //Метод тестирует негативный сценарий, с вводом только одного значения;
        //Ожидаем 'Not valid date', т.к. у треугольника должны быть три значения;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?b=1');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }

    public function getTriangleCheckWrongParameters(ApiTester $I)
        //Метод тестирует негативный сценарий, с вводом неверных параметров a,h,w;
        //Ожидаем 'Not valid date', т.к. должны приниматься параметры a,b,c;
    {
        $data = ["message" => ["error" => "Not valid date"]];
        $I->sendGet('/triangle/possible?a=2&h=3&w=4');

        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::BAD_REQUEST); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($data));
    }
}