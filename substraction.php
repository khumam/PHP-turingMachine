<?php

// turing machine

$states = [1, 2, 3, 4, 5, 6, 7];
$accept_states = [7];

// quintuple
// state, read condition, write value, move direction, new state

$rules = [
    1 => ['1' => ['1', 'r', 1],
          '-' => ['-', 'r', 2]],
    2 => ['_' => ['_', 'r', 2],
          '1' => ['_', 'l', 3],
          '_' => ['_', 'l', 6]],
    3 => ['_' => ['_', 'l', 3],
          '-' => ['-', 'l', 4]],
    4 => ['1' => ['1', 'l', 4],
          '_' => ['_', 'r', 5]],
    5 => ['1' => ['_', 'r', 1]],
    6 => ['_' => ['_', 'l', 6],
          '-' => ['_', 'l', 7]],
];

// input number in unary (2-1)
$tape = ['1','1','-','1'];
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
