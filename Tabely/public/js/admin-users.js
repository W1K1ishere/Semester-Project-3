document.getElementById('department_users').addEventListener('change', function () {
    const departmentId = this.value;
    window.location.href = `/admin/users/${departmentId}`;
});
