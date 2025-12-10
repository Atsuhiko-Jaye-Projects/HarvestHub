<?php

print_r ($_POST);
?>

<form method="POST" action="test3.php">

  <div id="expense-frame" class="frame">
    <div class="expense-row">
      <input type="text" name="expense_name[]" placeholder="Expense name" required>
      <input type="number" step="0.01" name="amount[]" placeholder="Amount" required>
    </div>
  </div>

  <button type="button" onclick="addRow()">+ Add more</button>
  <br><br>
  <button type="submit">Save Expenses</button>

</form>

<style>
.frame{
  max-height: 300px;
  overflow-y: auto;
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 8px;
}
.expense-row{
  display: flex;
  gap: 10px;
  margin-bottom: 8px;
}
</style>

<script>
function addRow(){
  const frame = document.getElementById("expense-frame");

  const div = document.createElement("div");
  div.className = "expense-row";
  div.innerHTML = `
      <input type="text" name="expense_name[]" placeholder="Expense name" required>
      <input type="number" step="0.01" name="amount[]" placeholder="Amount" required>
      <button type="button" onclick="this.parentElement.remove()">X</button>
  `;
  frame.appendChild(div);
}
</script>
