<?php
// интерфейс для общего описания каждого перевозчика
interface ShippingInterface {
    public function calculateShippingCost($weight);
}

// Почта России. Переопределяем функцию calculateShippingCost()
class RussianPost implements ShippingInterface {
    public function calculateShippingCost($weight) {
        if ($weight <= 10) {
            return 100;
        } else {
            return 1000;
        }
    }
}


// DHL. Переопределяем функцию calculateShippingCost()
class DHL implements ShippingInterface {
    public function calculateShippingCost($weight) {
        return $weight * 100;
    }
}


// ЗДЕСЬ можно вставить других перевозчиков как классы 


// класс-калькулятор который высчитывает контрольную сумму в зависимости от выбранного перевозчика 
class ShippingCalculator {
    protected $shippingMethods = [];

public function __construct(array $shippingMethods) {
    $this->shippingMethods = $shippingMethods;
}

public function calculateShippingCost($method, $weight) {
    if (isset($this->shippingMethods[$method])) {
        return $this->shippingMethods[$method]->calculateShippingCost($weight);
    } else {
        throw new Exception("Такой перевозчик не найден.");
    }
}
}


// ЕСЛИ добавляем новый класс нужно также добавить сюда.
$shippingMethods = array('Почта России' => new RussianPost(), 'DHL' => new DHL());

$calculator = new ShippingCalculator($shippingMethods);

// выбор конкретного перевозчика и веса 
$method = 'Почта России';
$weight = 15;

// вывод
try {
    // считаем
    $cost = $calculator->calculateShippingCost($method, $weight);
    echo "Перевозка в '$method' посылки весом $weight кг будет стоить $cost рублей.";
} catch (Exception $e) {
    echo $e->getMessage();
}

echo('<br />');
// выбор конкретного перевозчика и веса 
$method = 'DHL';
$weight = 15;

// вывод
try {
    // считаем
    $cost = $calculator->calculateShippingCost($method, $weight);
    echo "Перевозка в '$method' посылки весом $weight кг будет стоить $cost рублей.";
} catch (Exception $e) {
    echo $e->getMessage();
}

?>