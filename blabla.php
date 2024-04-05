<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dodavanje novih dropdownova</title>
</head>
<body>

<div id="dropdown-container">
  <div>
    <label for="car-brand">Odaberi marku automobila:</label>
    <select id="car-brand" class="car-brand">
      <option value="Audi">Audi</option>
      <option value="BMW">BMW</option>
      <option value="Mercedes">Mercedes</option>
      <option value="Toyota">Toyota</option>
      <!-- Dodajte više opcija po potrebi -->
    </select>
  </div>
  <button onclick="addNewDropdown()">Dodaj novi dropdown</button>
</div>

<script>
function addNewDropdown() {
  const container = document.getElementById('dropdown-container');
  const previousDropdowns = document.querySelectorAll('.car-brand');
  
  // Stvori novi dropdown
  const newDropdown = document.createElement('div');
  const label = document.createElement('label');
  label.textContent = 'Odaberi marku automobila:';
  const select = document.createElement('select');
  select.classList.add('car-brand');
  
  // Kopiraj opcije iz originalnog dropdowna
  const options = document.querySelectorAll('#car-brand option');
  options.forEach(option => {
    const newOption = document.createElement('option');
    newOption.value = option.value;
    newOption.textContent = option.textContent;
    select.appendChild(newOption);
  });
  
  // Ukloni već odabrane marke iz novog dropdowna
  previousDropdowns.forEach(previousDropdown => {
    const selectedOption = previousDropdown.value;
    const optionsToRemove = select.querySelectorAll(`option[value="${selectedOption}"]`);
    optionsToRemove.forEach(option => {
      option.remove();
    });
  });
  
  newDropdown.appendChild(label);
  newDropdown.appendChild(select);
  container.insertBefore(newDropdown, container.lastElementChild);
}
</script>

</body>
</html>
