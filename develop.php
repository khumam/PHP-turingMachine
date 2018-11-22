<?php

// turing machine

$states = [1, 2, 3, 4, 5, 6];   // Number of states
$accept_states = [6];           // Final State

// state => ['read_condition' => ['write_value', 'move_direction', 'new_state'];

$rules = [
    1 => ['1' => ['a', 'r', 2],
          '+' => ['_', 'r', 6]],
    2 => ['1' => ['1', 'r', 2],
          '+' => ['+', 'r', 3]],
];

// input tape

$tape = ['1','1'];
$position = 0;      // the position of the tape starts. Remember that array is start from 0; 
$state = 1;         // Initial State

// The Process

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
