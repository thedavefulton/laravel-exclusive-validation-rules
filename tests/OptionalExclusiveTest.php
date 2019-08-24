<?php

namespace Tests\Unit;

use Tests\TestCase;

class OptionalExclusiveTest extends TestCase
{
    /** @test */
    public function it_allows_no_inputs()
    {
        $this->withoutExceptionHandling();

        $rules = [
            'input1' => 'optional_exclusive:input2',
            'input2' => 'optional_exclusive:input1',
        ];

        $attributes = [];
        $this->assertTrue($this->app['validator']->make($attributes, $rules)->passes());
    }

    /** @test */
    public function it_allows_exactly_one_input()
    {
        $this->withoutExceptionHandling();

        $rules = [
            'input1' => 'optional_exclusive:input2',
            'input2' => 'optional_exclusive:input1',
        ];

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
    public function it_works_with_many_inputs()
    {
        $this->withoutExceptionHandling();

        $rules = [
            'input1' => 'optional_exclusive:input2,input3',
            'input2' => 'optional_exclusive:input1,input3',
            'input3' => 'optional_exclusive:input2,input3',
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

        $attributes = [];
        $this->assertTrue($this->app['validator']->make($attributes, $rules)->passes());
    }

    /** @test */
    public function it_works_with_nullable()
    {
        $this->withoutExceptionHandling();

        $rules = [
            'input1' => 'nullable|optional_exclusive:input2',
            'input2' => 'nullable|optional_exclusive:input1',
        ];

        $attributes = [
            'input1' => '',
            'input2' => 'some more text',
        ];
        $this->assertTrue($this->app['validator']->make($attributes, $rules)->passes());

        $attributes = [
            'input1' => '',
            'input2' => '',
        ];
        $this->assertTrue($this->app['validator']->make($attributes, $rules)->passes());
    }
}
