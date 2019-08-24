<?php

namespace Thedavefulton\LaravelExclusiveValidationRules\Tests;

use Orchestra\Testbench\TestCase;
use Thedavefulton\LaravelExclusiveValidationRules\ExclusiveValidationRulesServiceProvider;

class RequiredExclusiveTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            ExclusiveValidationRulesServiceProvider::class,
        ];
    }

    /** @test */
    public function it_requires_at_least_one_input()
    {
        $this->withoutExceptionHandling();

        $rules = [
            'input1' => 'required_exclusive:input2',
            'input2' => 'required_exclusive:input1',
        ];

        $attributes = [];
        $validator = $this->app['validator']->make($attributes, $rules);
        $this->assertFalse($validator->passes());

        $attributes = [
            'input1' => 'some text',
        ];
        $validator = $this->app['validator']->make($attributes, $rules);
        $this->assertTrue($validator->passes());
    }

    /** @test */
    public function it_requires_exactly_one_input()
    {
        $this->withoutExceptionHandling();

        $rules = [
            'input1' => 'required_exclusive:input2',
            'input2' => 'required_exclusive:input1',
        ];

        $attributes = [
            'input1' => 'some text',
            'input2' => 'some more text',
        ];
        $validator = $this->app['validator']->make($attributes, $rules);
        $this->assertFalse($validator->passes());

        $attributes = [
            'input1' => 'some text',
        ];
        $this->assertTrue($this->app['validator']->make($attributes, $rules)->passes());
    }

    /** @test */
    public function it_works_with_many_inputs()
    {
        $this->withoutExceptionHandling();

        $rules = [
            'input1' => 'required_exclusive:input2,input3',
            'input2' => 'required_exclusive:input1,input3',
            'input3' => 'required_exclusive:input1,input2',
        ];

        $attributes = [
            'input1' => 'some text',
            'input2' => 'some more text',
            'input3' => 'even more text',
        ];
        $this->assertFalse($this->app['validator']->make($attributes, $rules)->passes());

        $attributes = [
            'input1' => 'some text',
            'input2' => 'some more text',
        ];
        $this->assertFalse($this->app['validator']->make($attributes, $rules)->passes());

        $attributes = [
            'input1' => 'some text',
        ];
        $this->assertTrue($this->app['validator']->make($attributes, $rules)->passes());
    }

    /** @test */
    public function it_works_with_nullable()
    {
        $this->withoutExceptionHandling();

        $rules = [
            'input1' => 'nullable|required_exclusive:input2',
            'input2' => 'nullable|required_exclusive:input1',
        ];

        $attributes = [
            'input1' => '',
            'input2' => '',
        ];
        $this->assertFalse($this->app['validator']->make($attributes, $rules)->passes());

        $attributes = [
            'input1' => 'some text',
            'input2' => '',
        ];
        $this->assertTrue($this->app['validator']->make($attributes, $rules)->passes());


        $rules = [
            'input1' => 'string',
        ];
        $attributes = [
            'input1' => 123,
        ];
    }
}
