<?php
$pattern = '/test\.(\w+)/';
$stats = array();
$count = 0;

function lines(string $filename) {
    $file = new SplFileObject($filename);
    while (!$file->eof()) {
        yield $file->fgets();
    }
}

$printFile = function(int $count) {
    foreach (lines('example.log') as $line) {
        $count += 1;
        echo $count . ". " . $line . "<br>";
    }
};

$fileContent = lines('example.log');
foreach ($fileContent as $line) {
    if (preg_match($pattern, $line, $matches)) {
        $level = strtolower($matches[1]);
    }
    if ($level != 'debug'){
        $stats[$level]++;
    }else{
        $stats[$level] = 1;
    }
}

arsort($stats);
function callStats(iterable $stats){
    echo "<br>";
    foreach($stats as $level => $count) {
        echo "$level: $count" . "<br>";
    }
}

echo $printFile(1);
callStats($stats);
?>