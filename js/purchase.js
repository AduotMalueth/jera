let purchaseHistory = [];
let currentEditIndex = null;

// Update summary details dynamically
function updateSummary() {
    const totalCoconuts = purchaseHistory.reduce((sum, purchase) => sum + parseInt(purchase.quantity), 0);
    const lastPurchaseDate = purchaseHistory.length > 0 ? purchaseHistory[purchaseHistory.length - 1].date : 'N/A';

    document.getElementById('totalCoconuts').innerText = totalCoconuts;
    document.getElementById('lastPurchaseDate').innerText = lastPurchaseDate;
}

// Render the purchase history table
function renderPurchaseHistory() {
    const tableBody = document.getElementById('purchaseTableBody');
    tableBody.innerHTML = '';

    purchaseHistory.forEach((purchase, index) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${purchase.id}</td>
            <td>${purchase.date}</td>
            <td>${purchase.region}</td>
            <td>${purchase.quantity}</td>
            <td>${purchase.cost}</td>
            <td>${purchase.seller}</td>
            <td>${purchase.status}</td>
            <td>
                <button onclick="editPurchase(${index})">Edit</button>
                <button onclick="deletePurchase(${index})">Delete</button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    updateSummary();
}

// Add purchase
function addPurchase() {
    const date = document.getElementById('purchaseDate').value;
    const region = document.getElementById('purchaseRegion').value;
    const quantity = document.getElementById('purchaseQuantity').value;
    const cost = document.getElementById('purchaseCost').value;
    const seller = document.getElementById('purchaseSeller').value;
    const status = document.getElementById('purchaseStatus').value;

    if (currentEditIndex !== null) {
        purchaseHistory[currentEditIndex] = { id: currentEditIndex + 1, date, region, quantity, cost, seller, status };
        currentEditIndex = null;
    } else {
        const id = purchaseHistory.length + 1;
        purchaseHistory.push({ id, date, region, quantity, cost, seller, status });
    }

    closeModal('addPurchaseModal');
    renderPurchaseHistory();
}

// Edit purchase
function editPurchase(index) {
    const purchase = purchaseHistory[index];
    currentEditIndex = index;

    document.getElementById('purchaseDate').value = purchase.date;
    document.getElementById('purchaseRegion').value = purchase.region;
    document.getElementById('purchaseQuantity').value = purchase.quantity;
    document.getElementById('purchaseCost').value = purchase.cost;
    document.getElementById('purchaseSeller').value = purchase.seller;
    document.getElementById('purchaseStatus').value = purchase.status;

    openAddPurchaseModal();
}

// Delete purchase
function deletePurchase(index) {
    if (confirm('Are you sure you want to delete this purchase?')) {
        purchaseHistory.splice(index, 1);
        renderPurchaseHistory();
    }
}

// Open modal
function openAddPurchaseModal() {
    document.getElementById('addPurchaseModal').style.display = 'block';
}

// Close modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
    document.getElementById('addPurchaseForm').reset();
}

// Initialize
renderPurchaseHistory();