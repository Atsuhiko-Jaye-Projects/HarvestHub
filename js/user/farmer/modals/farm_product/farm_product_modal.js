/**
 * 1. FUNCTION: editHarvestProduct
 * DESIGN: Sleek Minimalist Glassmorphism
 * Gagamitin para sa pag-update ng existing harvest records.
 */
function editHarvestProduct(row) {
  return `
  <div class="modal fade" id="edit-harvest-modal-${row.id}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-2xl" style="border-radius: 30px; background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <form action="${UpdatePostURL}" method="POST" enctype="multipart/form-data">
          
          <div class="modal-header border-0 px-4 pt-4">
            <h5 class="fw-bold d-flex align-items-center">
              <span class="p-2 bg-primary bg-opacity-10 rounded-3 me-2">
                <i class="bi bi-pencil-square text-primary"></i>
              </span>
              Update Records
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <div class="modal-body px-4">
            <div class="row g-3">
              <div class="col-md-12">
                <div class="form-floating mb-2">
                  <input type="text" name="product_name" class="form-control border-0 bg-light rounded-4" id="prodName-${row.id}" value="${row.product_name}" required>
                  <label for="prodName-${row.id}">Product Name</label>
                </div>
              </div>

              <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 border-0">
                  <small class="text-muted fw-bold d-block mb-1">REFERENCE PRICE/KG</small>
                  <span class="h6 fw-bold text-dark">${Number(row.price_per_unit).toLocaleString('en-PH', { style: 'currency', currency: 'PHP' })}</span>
                  <input type="hidden" name="price_per_unit" value="${row.price_per_unit}">
                </div>
              </div>

              <div class="col-md-6">
                <div class="p-3 bg-light rounded-4 border-0">
                  <small class="text-muted fw-bold d-block mb-1">UNIT MEASURE</small>
                  <span class="h6 fw-bold text-dark text-uppercase">${row.unit}</span>
                  <input type="hidden" name="unit" value="${row.unit}">
                </div>
              </div>

              <div class="col-md-12">
                <label class="form-label small fw-bold text-muted ps-2">Harvest Summary</label>
                <textarea name="product_description" class="form-control border-0 bg-light rounded-4 p-3" rows="3" required>${row.product_description}</textarea>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-bold text-primary ps-2">Farm Area (sqm)</label>
                <div class="input-group">
                  <span class="input-group-text border-0 bg-primary bg-opacity-10 text-primary rounded-start-4"><i class="bi bi-geo"></i></span>
                  <input type="number" name="lot_size" value="${row.lot_size}" class="form-control border-0 bg-light rounded-end-4" required>
                </div>
              </div>

              <div class="col-md-6">
                <label class="form-label small fw-bold text-muted ps-2">Upload New Photo</label>
                <input type="file" name="product_image" class="form-control border-0 bg-light rounded-4">
              </div>
            </div>
            
            <input type="hidden" name="product_id" value="${row.id}">
            <input type="hidden" name="action" value="update">
          </div>

          <div class="modal-footer border-0 p-4 pt-0">
            <button type="button" class="btn btn-link text-muted text-decoration-none px-4" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-lg fw-bold">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  `;
}

/**
 * 2. FUNCTION: postHarvestProduct
 * DESIGN: Ultra-Modern Economic Dashboard with Profitability Logic
 * Gagamitin para ilipat ang harvest papunta sa Market (Product Posting).
 */
function capitalizeWords(str) {
  return str.replace(/\b\w/g, function(char) {
    return char.toUpperCase();
  });
}

function postHarvestProduct(row) {
  const farmSize = parseFloat(row.lot_size) || 1;
  const costPerKg = parseFloat(row.price_per_unit) || 0;
  const totalExpense = parseFloat(row.expense) || 0;

  return `
  <div class="modal fade" id="post-harvest-modal-${row.id}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
      <div class="modal-content border-0 shadow-2xl" style="border-radius: 35px; background: #ffffff;">
        
        <form action="${ProductPostingURL}" method="POST" enctype="multipart/form-data" id="postForm-${row.id}">
          
          <input type="hidden" name="product_id" value="${row.id}">
          <input type="hidden" name="product_name" value="${row.product_name}">
          <input type="hidden" name="unit" value="${row.unit}">
          <input type="hidden" name="product_description" value="${row.product_description}">
          <input type="hidden" name="lot_size" value="${row.lot_size}">
          <input type="hidden" name="product_image" value="${row.product_image}">
          <input type="hidden" name="is_posted" value="1">
          <input type="hidden" name="action" value="product_post">
          
          <input type="hidden" id="farm-size-${row.id}" value="${farmSize}">
          <input type="hidden" id="total-expense-${row.id}" value="${totalExpense}">

          <div class="modal-body p-0">
            <div class="row g-0">
              
              <div class="col-lg-4 p-4 p-md-5 bg-light" style="border-radius: 35px 0 0 35px;">
                
                <div class="position-relative mb-4">
                  <img src="${row.product_image_path}" class="w-100 rounded-5 shadow-lg" style="height: 250px; object-fit: cover;">
                  <span class="position-absolute top-0 start-0 m-3 badge rounded-pill bg-white text-dark shadow-sm px-3 py-2 fw-bold border">
                    <i class="bi bi-tag-fill text-success me-1"></i> Harvest Hub
                  </span>
                </div>
                
                <h3 class="fw-bold text-dark mb-1">${capitalizeWords(row.product_name)}</h3>
                <p class="text-muted small mb-4">${row.product_description}</p>
                
                <div class="p-4 rounded-5 bg-white shadow-sm border border-light">
                  <div class="d-flex justify-content-between mb-2">
                    <span class="small text-muted fw-bold">FARM SIZE</span>
                    <span class="small fw-bold">${row.lot_size} sqm</span>
                  </div>
                  <div class="d-flex justify-content-between mb-0">
                    <span class="small text-muted fw-bold">PRODUCTION</span>
                    <span id="prod-sqm-label-${row.id}" class="small fw-bold text-primary">0.00 kg/sqm</span>
                  </div>
                </div>
              </div>

              <div class="col-lg-8 p-4 p-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                  <h4 class="fw-bold m-0 text-dark">Market Pricing Dashboard</h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="row g-3 mb-4">
                  <div class="col-md-4">
                    <div class="p-3 rounded-5 bg-primary bg-opacity-10 border border-primary border-opacity-10">
                      <small class="text-primary fw-bold d-block mb-1">TOTAL YIELD</small>
                      <h4 id="yield-label-${row.id}" class="fw-bold mb-0 text-primary">${row.total_stocks} KG</h4>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="p-3 rounded-5 bg-danger bg-opacity-10 border border-danger border-opacity-10">
                      <small class="text-danger fw-bold d-block mb-1">TOTAL EXPENSES</small>
                      <h4 class="fw-bold mb-0 text-danger">₱${totalExpense.toLocaleString()}</h4>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div id="net-card-${row.id}" class="p-3 rounded-5 bg-dark text-white shadow-lg transition-all" style="transition: 0.3s;">
                      <small class="opacity-75 fw-bold d-block mb-1">EST. NET INCOME</small>
                      <h4 id="net-income-label-${row.id}" class="fw-bold mb-0">₱0.00</h4>
                    </div>
                  </div>
                </div>

                <div class="row g-4">
                  <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted ps-2">Verify Harvest Stocks (KG)</label>
                    <input type="number" name="total_stocks" id="stocks-${row.id}" value="${row.total_stocks}" class="form-control form-control-lg border-0 bg-light rounded-4 px-4 shadow-inner">
                  </div>
                  <div class="col-md-6">
                    <label class="form-label small fw-bold text-muted ps-2">Cost per KG (Break-even)</label>
                    <input type="text" class="form-control form-control-lg border-0 bg-light rounded-4 px-4 text-danger fw-bold" value="₱${costPerKg.toFixed(2)}" readonly>
                    <input type="hidden" id="cost-${row.id}" value="${costPerKg}">
                  </div>

                  <div class="col-md-12">
                    <div class="p-4 rounded-5 border-2 border-dashed border-success bg-success bg-opacity-10">
                       <div class="row align-items-center">
                          <div class="col-md-7">
                            <label class="form-label fw-bold text-success mb-2">Set Your Selling Price per KG</label>
                            <div class="input-group input-group-lg shadow-sm">
                              <span class="input-group-text border-0 bg-success text-white rounded-start-4">₱</span>
                              <input type="number" step="0.01" name="selling_price" class="form-control border-0 rounded-end-4 fw-bold" id="selling-price-${row.id}" placeholder="0.00" required>
                            </div>
                          </div>
                          <div class="col-md-5 text-end mt-3 mt-md-0">
                             <small class="text-muted d-block fw-bold mb-1">TOTAL ESTIMATED REVENUE</small>
                             <h3 id="revenue-text-${row.id}" class="fw-bold text-success mb-0">₱0.00</h3>
                          </div>
                       </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                     <div id="status-box-${row.id}" class="p-3 rounded-4 bg-light d-flex justify-content-between align-items-center transition-all">
                        <div class="d-flex align-items-center">
                           <div class="p-2 bg-white rounded-circle shadow-sm me-3" id="margin-icon-${row.id}">
                             <i class="bi bi-graph-up-arrow text-muted"></i>
                           </div>
                           <div>
                              <small class="text-muted fw-bold d-block">PROFIT MARGIN</small>
                              <span id="margin-text-${row.id}" class="fw-bold h5 mb-0">0%</span>
                           </div>
                        </div>
                        <span id="market-status-${row.id}" class="badge rounded-pill bg-secondary px-4 py-2">Waiting...</span>
                     </div>
                  </div>
                </div>

                <div class="mt-5 text-end">
                  <button type="button" class="btn btn-light rounded-pill px-4 py-2 me-2 fw-bold" data-bs-dismiss="modal">Discard</button>
                  <button type="submit" class="btn btn-success rounded-pill px-5 py-2 shadow-lg fw-bold" id='postButton-${row.id}'>Confirm & Post to Market</button>
                </div>

              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    (function() {
      const modal = document.getElementById('post-harvest-modal-${row.id}');
      const farmSize = parseFloat(modal.querySelector('#farm-size-${row.id}').value) || 1;
      const totalExp = parseFloat(modal.querySelector('#total-expense-${row.id}').value) || 0;
      
      const stocksIn = modal.querySelector('#stocks-${row.id}');
      const priceIn  = modal.querySelector('#selling-price-${row.id}');
      const costIn   = modal.querySelector('#cost-${row.id}');

      const pSqmLabel = modal.querySelector('#prod-sqm-label-${row.id}');
      const yldLabel  = modal.querySelector('#yield-label-${row.id}');
      const revText   = modal.querySelector('#revenue-text-${row.id}');
      const netLabel  = modal.querySelector('#net-income-label-${row.id}');
      const marginTxt = modal.querySelector('#margin-text-${row.id}');
      const mktStatus = modal.querySelector('#market-status-${row.id}');
      const postBtn   = modal.querySelector('#postButton-${row.id}');
      const netCard   = modal.querySelector('#net-card-${row.id}');

      function updateUI() {
        const stocks = parseFloat(stocksIn.value) || 0;
        const price  = parseFloat(priceIn.value) || 0;
        const cost   = parseFloat(costIn.value) || 0;

        pSqmLabel.innerText = (stocks / farmSize).toFixed(2) + " kg/sqm";
        yldLabel.innerText = stocks.toFixed(2) + " KG";

        const totalRevenue = stocks * price;
        revText.innerText = "₱" + totalRevenue.toLocaleString(undefined, {minimumFractionDigits: 2});

        const netIncome = totalRevenue - totalExp;
        netLabel.innerText = "₱" + netIncome.toLocaleString(undefined, {minimumFractionDigits: 2});

        // Profit & Validation Logic
        if (price > 0) {
          const margin = ((price - cost) / cost) * 100;
          marginTxt.innerText = margin.toFixed(1) + "%";

          if (margin > 25) {
            mktStatus.innerText = "OVERPRICED";
            mktStatus.className = "badge rounded-pill bg-danger px-4 py-2";
            postBtn.disabled = true;
          } else if (margin < 0) {
            mktStatus.innerText = "LOW PRICE (LOSS)";
            mktStatus.className = "badge rounded-pill bg-danger px-4 py-2";
            postBtn.disabled = false;
          } else {
            mktStatus.innerText = "COMPLIANT";
            mktStatus.className = "badge rounded-pill bg-success px-4 py-2";
            postBtn.disabled = false;
          }
        }

        // Dynamic Feedback for Net Income
        if(netIncome > 0) {
          netCard.className = "p-3 rounded-5 bg-success text-white shadow-lg";
        } else if (netIncome < 0) {
          netCard.className = "p-3 rounded-5 bg-danger text-white shadow-lg";
        } else {
          netCard.className = "p-3 rounded-5 bg-dark text-white shadow-lg";
        }
      }

      modal.addEventListener('input', updateUI);
      updateUI();
    })();
  </script>
  `;
}