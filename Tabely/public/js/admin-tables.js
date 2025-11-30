document.getElementById('department').addEventListener('change', function () {
    const departmentId = this.value;
    window.location.href = `/admin/tables/${departmentId}`;
});
