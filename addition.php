<?php

// turing machine

$states = [1, 2, 3, 4, 5, 6];
$accept_states = [6];

// quintuple
// state, read condition, write value, move direction, new state

$rules = [
    1 => ['1' => ['a', 'r', 2],
          '+' => ['_', 'r', 6]],
    2 => ['1' => ['1', 'r', 2],
          '+' => ['+', 'r', 3]],
    3 => ['1' => ['1', 'r', 3],
          '_' => ['1', 'l', 4]],
    4 => ['1' => ['1', 'l', 4],
          '+' => ['+', 'l', 5]],
    5 => ['1' => ['1', 'l', 5],
          'a' => ['a', 'r', 1]],
];

// input number in unary (2+3)
$tape = ['1','1','+','1','1','1'];
$position = 0;
$state = 1;

class NoTransitionException extends RuntimeException {}
while (!in_array($state, $accept_states)) {
    $read_val = isset($tape[$position]) ? $tape[$position] : '_';
    if (!isset($rules[$state][$read_val])) {
        throw new NoTransitionException();
    }
    list($write_val, $move_dir, $new_state) = $rules[$state][$read_val];
    $tape[$position] = $write_val;
    if ('l' === $move_dir) {
        $position--;
        if ($position < 0) {
            $position++;
            array_unshift($tape, '_');
        }
    } else if ('r' === $move_dir) {
        $position++;
        if ($position >= count($tape)) {
            array_push($tape, '_');
        }
    }
    $state = $new_state;
}
$render_cell = function ($cell, $cell_pos) use ($position) {
    return ($position === $cell_pos) ? "($cell)" : $cell;
};

echo sprintf("Tape: %s\n",
    trim(
        implode('',
            array_map($render_cell, $tape, range(0, count($tape)-1))),
        '_'));
echo sprintf("Position: %s\n", $position);
echo sprintf("State: %s\n", $state);
