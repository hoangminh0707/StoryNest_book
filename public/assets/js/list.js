document.addEventListener('DOMContentLoaded', function() {
    const customerListElement = document.getElementById('customerList');
    if (customerListElement) {
        var options = {
            valueNames: ['customer_name', 'email', 'id', 'phone'],
            page: 10,
            pagination: true,
            plugins: [ListPagination({ left: 2, right: 2 })]
        };

        var customerList = new List('customerList', options);
    } else {
        console.error('Bảng với id "customerList" không tồn tại!');
    }
});
