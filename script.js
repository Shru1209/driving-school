// script.js
document.getElementById('openModal').onclick = function() {
    document.getElementById('paymentModal').style.display = 'block';
}

document.getElementById('closeModal').onclick = function() {
    document.getElementById('paymentModal').style.display = 'none';
    resetForm(); // Reset form on close
}

window.onclick = function(event) {
    if (event.target == document.getElementById('paymentModal')) {
        document.getElementById('paymentModal').style.display = 'none';
        resetForm(); // Reset form on close
    }
}

// Handle payment option clicks
document.getElementById('creditCardBtn').onclick = function() {
    showCardForm();
};

document.getElementById('debitCardBtn').onclick = function() {
    showCardForm();
};

document.getElementById('googlePayBtn').onclick = function() {
    // Call Google Pay function
    alert("Redirecting to Google Pay...");
    // You can call your Google Pay function here
};

// Show card form and hide payment options
function showCardForm() {
    document.getElementById('paymentOptions').style.display = 'none';
    document.getElementById('cardForm').classList.remove('hidden');
}

// Reset form
function resetForm() {
    document.getElementById('paymentOptions').style.display = 'block';
    document.getElementById('cardForm').classList.add('hidden');
    document.getElementById('paymentForm').reset(); // Reset the payment form
}

// Handle form submission
document.getElementById('paymentForm').onsubmit = function(event) {
    event.preventDefault(); // Prevent default form submission

    const cardNumber = document.getElementById('cardNumber').value;
    const expiryDate = document.getElementById('expiryDate').value;
    const cvv = document.getElementById('cvv').value;

    // Process the payment with the card details
    alert(`Processing payment...\nCard Number: ${cardNumber}\nExpiry: ${expiryDate}\nCVV: ${cvv}`);
    
    // Here you can call your payment processing logic
    // For example, sending this data to your server for processing
};
