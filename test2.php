<?php
/**
 * @charset UTF-8
 *
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм). Учесть переход времени на следующий день
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */


function validateTimeInterval($interval)
{
    $pattern = '/^([01]?[0-9]|2[0-3]):[0-5][0-9]-([01]?[0-9]|2[0-3]):[0-5][0-9]$/'; // Паттерн для проверки формата временного интервала

if (preg_match($pattern, $interval)) {
    return true;
} else {
    return false;
}
}

function checkIntervalOverlap($newInterval)
{
    global $list;
    
    $newIntervalParts = explode('-', $newInterval); // Разбиваем новый интервал на начало и конец
    $startTime = strtotime($newIntervalParts[0]); // Преобразуем время начала нового интервала в timestamp
    $endTime = strtotime($newIntervalParts[1]); // Преобразуем время окончания нового интервала в timestamp
    
    foreach ($list as $interval) {
        $intervalParts = explode('-', $interval); // Разбиваем существующий интервал на начало и конец
        
        $existingStartTime = strtotime($intervalParts[0]); // Преобразуем время начала существующего интервала в timestamp
        $existingEndTime = strtotime($intervalParts[1]); // Преобразуем время окончания существующего интервала в timestamp
        
            //Если переход на новый день
        if ($existingEndTime < $existingStartTime)
        {
            if (($startTime < $existingStartTime && $startTime > $existingEndTime) &&
            ($endTime < $existingStartTime && $endTime > $existingEndTime)
            ) {
                return false; // Произошло наложение интервалов
            }
            return true;
            //Если перехода на новый день нету
        }else{
            // Если начало нового интервала находится внутри существующего интервала
            // или конец нового интервала находится внутри существующего интервала
            // или новый интервал полностью содержится внутри существующего интервала
            if (($startTime >= $existingStartTime && $startTime <= $existingEndTime) ||
            ($endTime >= $existingStartTime && $endTime <= $existingEndTime)
            ) {
                return true; // Произошло наложение интервалов
            }   
        }
    }
    return false; // Наложения интервалов нет
}

function outputResult($newInterval)
{
    $newIntervalIsValid = validateTimeInterval($newInterval);
    if ($newIntervalIsValid) {
        $overlap = checkIntervalOverlap($newInterval);
        if ($overlap) {
            echo "Произошло наложение интервалов <br />";
        } else {
            echo "Наложения интервалов нет <br />";
        }
    } else {
        echo "Временной интервал невалиден <br />";
    }
    return;
}

# Можно использовать список:
$list = array (
    '11:30-13:00',
    '22:30-9:00',  
);

outputResult('13:00-14:50');
outputResult('13:01-14:50');
outputResult('2:13-3:50');
?>