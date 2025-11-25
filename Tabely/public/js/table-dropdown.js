document.getElementById('department').addEventListener('change', function () {
   const departmentId = this.value;
   const tableDropdown = document.getElementById('table');

   tableDropdown.innerHTML = '<option value="">Select Table</option>';

    if(tables[departmentId]) {
        tables[departmentId].forEach(table => {
            const depTable = document.createElement('option');
            depTable.value = table.id;
            depTable.textContent = table.id;
            tableDropdown.appendChild(depTable);
        })
    }
});
