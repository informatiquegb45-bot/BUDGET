const form = document.getElementById('sale-form');
const salesBody = document.getElementById('salesBody');

const totalRevenueEl = document.getElementById('totalRevenue');
const totalProfitEl = document.getElementById('totalProfit');
const totalReceivableEl = document.getElementById('totalReceivable');

const sales = [];

const formatCurrency = (value) =>
  new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
  }).format(value);

const formatDate = (dateString) => {
  if (!dateString) return '-';
  return new Date(dateString).toLocaleDateString('fr-FR');
};

const updateDashboard = () => {
  const totals = sales.reduce(
    (acc, item) => {
      const receivable = Math.max(item.saleAmount - item.paidAmount, 0);

      acc.revenue += item.saleAmount;
      acc.profit += item.saleAmount - item.costAmount;
      acc.receivable += receivable;
      return acc;
    },
    { revenue: 0, profit: 0, receivable: 0 }
  );

  totalRevenueEl.textContent = formatCurrency(totals.revenue);
  totalProfitEl.textContent = formatCurrency(totals.profit);
  totalReceivableEl.textContent = formatCurrency(totals.receivable);
};

const renderTable = () => {
  salesBody.innerHTML = '';

  sales
    .slice()
    .sort((a, b) => new Date(b.saleDate) - new Date(a.saleDate))
    .forEach((item) => {
      const receivable = Math.max(item.saleAmount - item.paidAmount, 0);

      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${item.type}</td>
        <td>${item.description}</td>
        <td>${formatCurrency(item.saleAmount)}</td>
        <td>${formatCurrency(item.costAmount)}</td>
        <td>${formatCurrency(item.paidAmount)}</td>
        <td>${formatCurrency(receivable)}</td>
        <td>${formatDate(item.saleDate)}</td>
        <td>${formatDate(item.debitDate)}</td>
      `;
      salesBody.appendChild(row);
    });
};

form.addEventListener('submit', (event) => {
  event.preventDefault();

  const saleAmount = Number(document.getElementById('saleAmount').value);
  const costAmount = Number(document.getElementById('costAmount').value);
  const paidAmount = Number(document.getElementById('paidAmount').value);

  if (paidAmount > saleAmount) {
    alert("Le montant encaissé ne peut pas dépasser le montant vendu.");
    return;
  }

  sales.push({
    type: document.getElementById('type').value,
    description: document.getElementById('description').value.trim(),
    saleAmount,
    costAmount,
    paidAmount,
    saleDate: document.getElementById('saleDate').value,
    debitDate: document.getElementById('debitDate').value,
  });

  form.reset();
  document.getElementById('paidAmount').value = 0;

  renderTable();
  updateDashboard();
});
