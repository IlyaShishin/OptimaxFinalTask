<?php

use Codeception\Example;
use Codeception\Util\HttpCode;


class TriangleCheckerCest
{
    /**
     * @dataProvider myProviderTrue
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

    /**
     * @dataProvider myProviderEquilateralTriangle
     */
    public function getTriangleWithSameValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует позитивный сценарий, с вводом трёх целых положительных одинаковых значений;
        //Ожидаем true, так как равносторонний треугольник может существовать;
    {
        $I->sendGet($dataProvider['url']);

        $I->seeResponseCodeIs($dataProvider['expectedCode']);
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderValuesWithZero
     */
    public function getTriangleWithValuesWithZero(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом трёх целых положительных двузначных, трёхзначных и четырёхзначных значений,
        //одно из которых содержит 0;
        //Ожидаем true, так как стороны треугольника могут быть равны двузначным и более-значным числам;
    {
        $I->sendGet($dataProvider['url']);

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderFalse
     */
    public function getTriangleWithWrongValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом трёх целых значений, нарушающих правило:
        // "Сумма двух сторон треугольника должна быть больше третьей стороны";
        //Ожидаем false, т.к. такой треугольникн не может существовать;
    {
        $I->sendGet('/triangle/possible?a=1&b=2&c=3');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderError
     */
    public function getTriangleWithNegativeValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом трёх целых отрицательных значений;
        //Ожидаем 'Not valid date', т.к. отрицательные значения не являются натуральными;
    {
        $I->sendGet('/triangle/possible?a=-1&b=-2&c=-3');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderError
     */
    public function getTriangleWithNotNaturalDotValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом одного рационального значения через символ '.' (точка);
        //Ожидаем 'Not valid date', т.к. рациональные значения не являются натуральными;
    {
        $I->sendGet('/triangle/possible?a=1&b=2&c=3.5');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderError
     */
    public function getTriangleWithNotNaturalCommaValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом одного рационального значения через символ ',' (запятая);
        //Ожидаем 'Not valid date', т.к. рациональные значения не являются натуральными;
    {
        $I->sendGet('/triangle/possible?a=1&b=2&c=3,5');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderError
     */
    public function getTriangleWithLiteralValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом буквенных значений;
        //Ожидаем 'Not valid date', т.к. в значения должны приниматься только натуральные числа;
    {
        $I->sendGet('/triangle/possible?a=a&b=b&c=c');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderTwoValues
     */
    public function getTriangleWithTwoValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом только двух значений;
        //Ожидаем 'Not valid date', т.к. у треугольника должны быть три значения;
    {
        $I->sendGet($dataProvider['url']);

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderOneValue
     */
    public function getTriangleWithOneValue(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом только одного значения;
        //Ожидаем 'Not valid date', т.к. у треугольника должны быть три значения;
    {
        $I->sendGet($dataProvider['url']);

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderError
     */
    public function getTriangleWithWrongParameters(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом неверных параметров a,h,w;
        //Ожидаем 'Not valid date', т.к. должны приниматься параметры a,b,c;
    {
        $I->sendGet('/triangle/possible?a=2&h=3&w=4');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderError
     */
    public function getTriangleWithSQLValue(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом в значение оператора запроса SQL;
        //Ожидаем 'Not valid date', т.к. в значения должны приниматься только натуральные числа;
    {
        $I->sendGet('/triangle/possible?a=select&b=3&c=4');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    private function myProviderTrue(): Generator
    {
        yield[
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => true]
        ];
    }

    private function myProviderFalse(): Generator
    {
        yield[
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => false]
        ];
    }

    private function myProviderError(): Generator
    {
        yield[
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ["message" => ["error" => "Not valid date"]]
        ];
    }

    private function myProviderValuesWithZero(): Generator
    {
        yield 'Two-digit values with zero' => [
            'url' => '/triangle/possible?a=10&b=13&c=15',
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => true]
        ];

        yield 'Two-digit values with zero' => [
            'url' => '/triangle/possible?a=11&b=13&c=15',
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => true]
        ];

        yield 'Three-digit values with zero' => [
            'url' => '/triangle/possible?a=111&b=103&c=155',
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => true]
        ];

        yield 'Three-digit values with zero' => [
            'url' => '/triangle/possible?a=111&b=113&c=155',
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => true]
        ];

        yield 'Four-digit values with zero' => [
            'url' => '/triangle/possible?a=1345&b=2489&c=2780',
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => true]
        ];

        yield 'Four-digit values with zero' => [
            'url' => '/triangle/possible?a=1345&b=2489&c=2781',
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => true]
        ];
    }

    private function myProviderTwoValues(): Generator
    {
        yield 'a and b values' => [
            'url' => '/triangle/possible?a=12&b=13',
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ["message" => ["error" => "Not valid date"]]
        ];

        yield 'b and c values' => [
            'url' => '/triangle/possible?b=12&c=13',
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ["message" => ["error" => "Not valid date"]]
        ];

        yield 'a and c values' => [
            'url' => '/triangle/possible?a=111&c=155',
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ["message" => ["error" => "Not valid date"]]
        ];
    }

    private function myProviderOneValue(): Generator
    {
        yield 'only a value' => [
            'url' => '/triangle/possible?a=12',
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ["message" => ["error" => "Not valid date"]]
        ];

        yield 'only b value' => [
            'url' => '/triangle/possible?b=12',
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ["message" => ["error" => "Not valid date"]]
        ];

        yield 'only c value' => [
            'url' => '/triangle/possible?c=155',
            'expectedCode' => HttpCode::BAD_REQUEST,
            'expectedMessage' => ["message" => ["error" => "Not valid date"]]
        ];
    }

    private function myProviderEquilateralTriangle(): Generator
    {
        yield 'same values' => [
            'url' => '/triangle/possible?a=3&b=3&c=3',
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => true]
        ];

        yield 'same values with zero' => [
            'url' => '/triangle/possible?a=0&b=0&c=0',
            'expectedCode' => HttpCode::OK,
            'expectedMessage' => ["isPossible" => false]
        ];
    }
}