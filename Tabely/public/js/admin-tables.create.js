document.getElementById('department_create').addEventListener('change', function () {
    const departmentId = this.value;
    window.location.href = `/admin/tables/create/${departmentId}`;
});
