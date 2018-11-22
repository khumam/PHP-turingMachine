<?php

// turing machine

$states = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13];
$accept_states = [13];

// quintuple
// state, read condition, write value, move direction, new state

$rules = [
    1 => ['1' => ['1', 'r', 1],
          '*' => ['*', 'r', 2]],
    2 => ['1' => ['1', 'r', 2],
          '_' => ['*', 'l', 3]],
    3 => ['1' => ['1', 'l', 3],
          '*' => ['*', 'r', 4]],
    4 => ['a' => ['a', 'r', 4],
          '*' => ['_', 'r', 13],
          '1' => ['a', 'l', 5]],
    5 => ['a' => ['a', 'l', 5],
          '*' => ['*', 'l', 6]],
    6 => ['b' => ['b', 'l', 6],
          '1' => ['b', 'r', 7],
          '_' => ['_', 'r', 12]],
    7 => ['b' => ['b', 'r', 7],
          '*' => ['*', 'r', 8]],
    8 => ['1' => ['1', 'r', 8],
          'a' => ['a', 'r', 8],
          '*' => ['*', 'r', 9]],
    9 => ['1' => ['1', 'r', 9],
          '_' => ['1', 'l', 10]],
   10 => ['1' => ['1', 'l', 10],
          '*' => ['*', 'l', 11]],
   11 => ['a' => ['a', 'l', 11],
          '1' => ['1', 'l', 11],
          '*' => ['*', 'l', 6]],
   12 => ['b' => ['1', 'r', 12],
          '*' => ['*', 'r', 4]],
];

// input number in unary (3*1)
$tape = ['1','1','1','*','1'];
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
