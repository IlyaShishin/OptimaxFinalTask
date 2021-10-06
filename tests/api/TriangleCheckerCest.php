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
     * @dataProvider myProviderTrue
     */
    public function getTriangleWithSameValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует позитивный сценарий, с вводом трёх целых положительных одинаковых значений;
        //Ожидаем true, так как равносторонний треугольник может существовать;
    {
        $I->sendGet('/triangle/possible?a=3&b=3&c=3');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //200
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderTrue
     */
    public function getTriangleWithTwoDigitValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует позитивный сценарий, с вводом трёх целых положительных двузначных значений;
        //Ожидаем true, так как стороны треугольника могут быть равны двузначным и более-значным числам;
    {
        $I->sendGet('/triangle/possible?a=10&b=13&c=15');

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
        //Ожидаем 'Not valid date', т.к. буквенные значения не являются натуральными;
    {
        $I->sendGet('/triangle/possible?a=a&b=b&c=c');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderError
     */
    public function getTriangleWithTwoValues(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом только двух значений;
        //Ожидаем 'Not valid date', т.к. у треугольника должны быть три значения;
    {
        $I->sendGet('/triangle/possible?b=1&c=2');

        $I->seeResponseCodeIs($dataProvider['expectedCode']); //400
        $I->seeResponseIsJson();
        $I->seeResponseContains(json_encode($dataProvider['expectedMessage']));
    }

    /**
     * @dataProvider myProviderError
     */
    public function getTriangleWithOneValue(ApiTester $I, Example $dataProvider): void
        //Метод тестирует сценарий, с вводом только одного значения;
        //Ожидаем 'Not valid date', т.к. у треугольника должны быть три значения;
    {
        $I->sendGet('/triangle/possible?b=1');

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
}