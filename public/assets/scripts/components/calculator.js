function updateCalculatorUnits() {
    const metalType = document.getElementById('metalType');
    const unitSelect = document.getElementById('unitSelect');

    const selectedOption = metalType.selectedOptions[0];
    const units = selectedOption ? JSON.parse(selectedOption.dataset.units || '{}') : {};

    // Update unit select when product changes
    if (selectedOption && selectedOption.value) {
        unitSelect.innerHTML = '<option value="">Выберите единицу</option>';
        for (const [unit, price] of Object.entries(units)) {
            const unitLabel = unit === 'т' ? 'тонны' : unit === 'шт' ? 'штуки' : unit === 'м' ? 'метры' : unit;
            const option = document.createElement('option');
            option.value = unit;
            option.textContent = `${unitLabel} (${formatCurrency(price)}/${unit})`;
            option.dataset.price = price;
            unitSelect.appendChild(option);
        }
    } else {
        unitSelect.innerHTML = '<option value="">Сначала выберите тип</option>';
    }

    // Reset calculation
    document.getElementById('metalCost').textContent = '0 ₽';
    document.getElementById('deliveryCost').textContent = '0 ₽';
    document.getElementById('totalCost').textContent = '0 ₽';
}

function calculateMetal() {
    // Get input values
    const unitSelect = document.getElementById('unitSelect');
    const quantity = parseFloat(document.getElementById('quantity').value) || 0;
    const delivery = parseFloat(document.getElementById('delivery').value) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;

    // Get unit price
    const selectedUnit = unitSelect.selectedOptions[0];
    const unitPrice = selectedUnit ? parseFloat(selectedUnit.dataset.price) : 0;

    // Calculate metal cost
    const metalCost = unitPrice * quantity;

    // Calculate discount amount
    const discountAmount = metalCost * (discount / 100);

    // Calculate total with discount
    const totalCost = metalCost - discountAmount + delivery;

    // Update display
    document.getElementById('metalCost').textContent = formatCurrency(metalCost);
    document.getElementById('deliveryCost').textContent = formatCurrency(delivery);
    document.getElementById('totalCost').textContent = formatCurrency(totalCost);
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('ru-RU', {
        style: 'currency',
        currency: 'RUB',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}

// Add event listeners for real-time calculation
document.addEventListener('DOMContentLoaded', function() {
    const metalType = document.getElementById('metalType');
    const unitSelect = document.getElementById('unitSelect');
    const quantity = document.getElementById('quantity');
    const delivery = document.getElementById('delivery');
    const discount = document.getElementById('discount');

    if (metalType) {
        metalType.addEventListener('change', updateCalculatorUnits);
    }
    if (unitSelect) {
        unitSelect.addEventListener('change', calculateMetal);
    }
    if (quantity) {
        quantity.addEventListener('input', calculateMetal);
    }
    if (delivery) {
        delivery.addEventListener('change', calculateMetal);
    }
    if (discount) {
        discount.addEventListener('change', calculateMetal);
    }
});

// Also keep the quick calculator functions for the hero section form
function updatePriceDisplay() {
    const productSelect = document.getElementById('product-select');
    const unitSelect = document.getElementById('unit-select');
    const quantityInput = document.getElementById('quantity-input');
    const priceDisplay = document.getElementById('price-display');
    const unitPriceSpan = document.getElementById('unit-price');
    const totalPriceSpan = document.getElementById('total-price');

    if (!productSelect) return;

    const selectedOption = productSelect.selectedOptions[0];
    const units = selectedOption ? JSON.parse(selectedOption.dataset.units || '{}') : {};

    // Update unit select when product changes
    if (selectedOption && selectedOption.value) {
        unitSelect.innerHTML = '<option value="">Выберите единицу</option>';
        for (const [unit, price] of Object.entries(units)) {
            const unitLabel = unit === 'т' ? 'тонны' : unit === 'шт' ? 'штуки' : unit;
            const option = document.createElement('option');
            option.value = unit;
            option.textContent = `${unitLabel} (${formatCurrency(price)}/${unit})`;
            option.dataset.price = price;
            unitSelect.appendChild(option);
        }
    } else {
        unitSelect.innerHTML = '<option value="">Сначала выберите тип</option>';
    }

    // Calculate and display price
    const selectedUnit = unitSelect.selectedOptions[0];
    const unitPrice = selectedUnit ? parseFloat(selectedUnit.dataset.price) : 0;
    const quantity = parseFloat(quantityInput.value) || 0;

    if (unitPrice > 0 && quantity > 0) {
        const total = unitPrice * quantity;
        unitPriceSpan.textContent = formatCurrency(unitPrice);
        totalPriceSpan.textContent = formatCurrency(total);
        priceDisplay.classList.remove('hidden');
    } else {
        priceDisplay.classList.add('hidden');
    }
}

// Add event listeners for quick calculator
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product-select');
    const unitSelectQuick = document.getElementById('unit-select');
    const quantityInput = document.getElementById('quantity-input');

    if (productSelect) {
        productSelect.addEventListener('change', updatePriceDisplay);
    }
    if (unitSelectQuick) {
        unitSelectQuick.addEventListener('change', updatePriceDisplay);
    }
    if (quantityInput) {
        quantityInput.addEventListener('input', updatePriceDisplay);
    }
});
