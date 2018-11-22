<?php

// turing machine

$states = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11];
$accept_states = [11];

// quintuple
// state, read condition, write value, move direction, new state

$rules = [
    1 => ['_' => ['_', 'r', 2]],
    2 => ['1' => ['_', 'r', 3],
          '/' => ['_', 'r', 10]],
    3 => ['1' => ['1', 'r', 3],
          '/' => ['/', 'r', 4]],
    4 => ['a' => ['a', 'r', 4],
          '1' => ['1', 'r', 4],
          '_' => ['_', 'l', 5],
          'b' => ['b', 'l', 5]],
    5 => ['a' => ['a', 'l', 5],
          '1' => ['a', 'l', 6]],
    6 => ['/' => ['/', 'r', 7],
          '1' => ['1', 'l', 8]],
    7 => ['b' => ['b', 'r', 7],
          'a' => ['1', 'r', 7],
          '_' => ['b', 'l', 8]],
    8 => ['b' => ['b', 'l', 8],
          '1' => ['1', 'l', 8],
          '/' => ['/', 'l', 9]],
    9 => ['1' => ['1', 'l', 9],
          '_' => ['_', 'r', 2]],
   10 => ['1' => ['_', 'r', 10],
          'b' => ['1', 'r', 10],
          '_' => ['_', 'r', 11]],

];

// input number in unary (4/1)
$tape = ['1','1','1','1','/','1'];
$position = 0;
$state = 2;

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
