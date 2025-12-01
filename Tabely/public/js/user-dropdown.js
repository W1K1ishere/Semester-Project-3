document.getElementById('department_id').addEventListener('change', function () {
    const departmentId = this.value;
    const userDropdown = document.getElementById('user_id');

    userDropdown.innerHTML = '<option value="">Select employee</option>';

    if (groupedUsers[departmentId]) {
        groupedUsers[departmentId].forEach(user => {
            const option = document.createElement('option');
            option.value = user.id;
            option.textContent = user.name;
            userDropdown.appendChild(option);
        });
    }
});

if (selectedDepartmentId && selectedUserId) {
    document.getElementById('department_id').value = selectedDepartmentId;
    document.getElementById('department_id').dispatchEvent(new Event('change'));
    document.getElementById('user_id').value = selectedUserId;
}
