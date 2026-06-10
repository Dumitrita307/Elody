// ══════════════════════════════════
// COS DE CUMPARATURI — cos.js
// ══════════════════════════════════

var deliveryCost = 35;
var discountPct  = 0;

// ── Incarca cosul ──────────────────
function getCart() {
  try {
    return JSON.parse(localStorage.getItem('elody_cart')) || [];
  } catch(e) {
    return [];
  }
}

function saveCart(cart) {
  localStorage.setItem('elody_cart', JSON.stringify(cart));
  updateBadge();
}

function updateBadge() {
  var cart  = getCart();
  var total = cart.reduce(function(s, i) { return s + i.qty; }, 0);
  var badge = document.getElementById('cartBadge');
  if (badge) badge.textContent = total;
}

// ── Sterge produs din cos ──────────
function removeItem(id) {
  var cart = getCart().filter(function(i) { return i.id !== id; });
  saveCart(cart);
  render();
}

// ── Schimba cantitatea ─────────────
function changeQty(id, delta) {
  var cart = getCart();
  cart = cart.map(function(i) {
    if (i.id === id) {
      i.qty = Math.max(1, i.qty + delta);
    }
    return i;
  });
  saveCart(cart);
  render();
}

// ── Goleste cosul ──────────────────
function clearCart() {
  if (!confirm('Ești sigur că vrei să golești coșul?')) return;
  localStorage.removeItem('elody_cart');
  render();
}

// ── Aplica cupon ───────────────────
function applyCoupon() {
  var code = document.getElementById('couponInput').value.trim().toUpperCase();
  var msg  = document.getElementById('couponMsg');
  var coupons = { 'ELODY10': 10, 'FARMA20': 20, 'SANATATE15': 15 };

  if (coupons[code]) {
    discountPct = coupons[code];
    msg.textContent = '✓ Cod aplicat! Reducere ' + discountPct + '%';
    msg.style.color = '#2e7d32';
  } else {
    discountPct = 0;
    msg.textContent = '✗ Cod invalid';
    msg.style.color = '#c62828';
  }
  updateTotals();
}

// ── Actualizeaza livrarea ──────────
function updateDelivery(cost) {
  deliveryCost = cost;
  updateTotals();
}

// ── Calculeaza totaluri ────────────
function updateTotals() {
  var cart     = getCart();
  var subtotal = cart.reduce(function(s, i) { return s + i.price * i.qty; }, 0);
  var discount = subtotal * discountPct / 100;
  var total    = subtotal + deliveryCost - discount;

  var el = function(id) { return document.getElementById(id); };

  if (el('subtotalVal')) el('subtotalVal').textContent = subtotal.toFixed(2) + ' Lei';
  if (el('deliveryVal')) el('deliveryVal').textContent = deliveryCost === 0 ? 'Gratuit' : deliveryCost.toFixed(2) + ' Lei';
  if (el('totalVal'))    el('totalVal').textContent    = total.toFixed(2) + ' Lei';

  var discLine = el('discountLine');
  if (discLine) {
    discLine.style.display = discountPct > 0 ? 'flex' : 'none';
    if (el('discountVal')) el('discountVal').textContent = '-' + discount.toFixed(2) + ' Lei';
  }

  // Summary rows
  var rows = el('summaryRows');
  if (rows) {
    rows.innerHTML = cart.map(function(i) {
      return '<div class="summary-prod">' +
        '<span>' + i.name + ' x' + i.qty + '</span>' +
        '<strong>' + (i.price * i.qty).toFixed(2) + ' Lei</strong>' +
        '</div>';
    }).join('');
  }
}

// ── Randeaza cosul ─────────────────
function render() {
  var cart      = getCart();
  var cosLayout = document.getElementById('cosLayout');
  var cosEmpty  = document.getElementById('cosEmpty');
  var cosItems  = document.getElementById('cosItems');

  if (!cosItems) return;

  if (cart.length === 0) {
    if (cosLayout) cosLayout.style.display = 'none';
    if (cosEmpty)  cosEmpty.style.display  = 'flex';
    return;
  }

  if (cosLayout) cosLayout.style.display = 'grid';
  if (cosEmpty)  cosEmpty.style.display  = 'none';

  cosItems.innerHTML =
    '<div class="cos-header">' +
      '<h2><i class="fa-solid fa-cart-shopping"></i> Coșul tău (' + cart.length + ' produse)</h2>' +
      '<button class="btn-clear-cart" onclick="clearCart()">' +
        '<i class="fa-solid fa-trash"></i> Golește coșul' +
      '</button>' +
    '</div>' +
    cart.map(function(item) {
      return '<div class="cos-item" id="item-' + item.id + '">' +
        '<div class="cos-item__img">' +
          '<img src="' + (item.image || 'images/paracetamol.png') + '" alt="' + item.name + '" onerror="this.src=\'images/paracetamol.png\'">' +
        '</div>' +
        '<div class="cos-item__info">' +
          '<h3>' + item.name + '</h3>' +
          '<span class="cos-item__brand">' + (item.brand || '') + '</span>' +
          '<span class="cos-item__unit">' + (item.unit || '') + '</span>' +
        '</div>' +
        '<div class="cos-item__qty">' +
          '<button onclick="changeQty(' + item.id + ', -1)">−</button>' +
          '<span>' + item.qty + '</span>' +
          '<button onclick="changeQty(' + item.id + ', 1)">+</button>' +
        '</div>' +
        '<div class="cos-item__price">' +
          (item.price * item.qty).toFixed(2) + ' Lei' +
          '<small>' + item.price.toFixed(2) + ' Lei / buc.</small>' +
        '</div>' +
        '<button class="cos-item__remove" onclick="removeItem(' + item.id + ')" title="Șterge">' +
          '<i class="fa-solid fa-xmark"></i>' +
        '</button>' +
      '</div>';
    }).join('');

  updateTotals();
  updateBadge();
}

// ── Init ───────────────────────────
document.addEventListener('DOMContentLoaded', function() {
  render();
  updateBadge();
});