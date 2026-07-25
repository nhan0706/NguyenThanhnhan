document.addEventListener("submit", function (e) {
    const form = e.target.closest(".form-add-cart");
    if (!form) return;
    e.preventDefault();
    addToCart(form);
});

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-remove-cart");
    if (!btn) return;
    e.preventDefault();
    removeCart(btn);
});

document.addEventListener("change", function (e) {
    const input = e.target.closest(".input-update-cart");
    if (!input) return;
    updateCartQty(input);
});

function addToCart(form) {
    const url = form.action;
    const formData = new FormData(form);
    fetch(url, {
        method: "POST",
        body: formData,
        headers: {
            "Accept": "application/json"
        }
    })
    .then(res => {
        if (!res.ok) throw new Error("HTTP " + res.status);
        return res.json();
    })
    .then(data => {
        const cartCount = document.getElementById("cart-count");
        if (cartCount && data.cartCount !== undefined) {
            cartCount.innerText = data.cartCount;
        }

        if (typeof Swal !== "undefined") {
            Swal.fire({
                icon: "success",
                title: "Đã thêm vào giỏ!",
                text: data.message,
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        } else {
            alert(data.message);
        }
    })
    .catch(err => {
        console.error("Lỗi:", err);
    });
}

function removeCart(btn) {
    const executeRemove = () => {
        const url = btn.dataset.url;
        fetch(url, {
            method: "DELETE",
            headers: {
                "Accept": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => {
            if (!res.ok) throw new Error("HTTP " + res.status);
            return res.json();
        })
        .then(data => {
            if (!data.status) {
                if (typeof Swal !== "undefined") {
                    Swal.fire("Lỗi", data.message, "error");
                } else {
                    alert(data.message);
                }
                return;
            }
            btn.closest("tr").remove();

            const cartCount = document.getElementById("cart-count");
            if (cartCount) cartCount.innerText = data.cartCount;

            const totalQuantity = document.getElementById("totalQuantity");
            if (totalQuantity) totalQuantity.innerText = data.cartCount;

            const total = document.getElementById("total");
            if (total) {
                total.innerText = Number(data.total).toLocaleString("vi-VN") + " đ";
            }

            if (typeof Swal !== "undefined") {
                Swal.fire({
                    icon: "success",
                    title: "Đã xóa sản phẩm khỏi giỏ hàng",
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 2000
                });
            }

            if (data.isEmpty) {
                location.reload();
            }
        })
        .catch(err => {
            console.error(err);
        });
    };

    if (typeof Swal !== "undefined") {
        Swal.fire({
            title: "Xác nhận xóa?",
            text: "Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Đồng ý xóa",
            cancelButtonText: "Hủy"
        }).then(result => {
            if (result.isConfirmed) {
                executeRemove();
            }
        });
    } else {
        if (confirm("Bạn có chắc muốn xóa sản phẩm này?")) {
            executeRemove();
        }
    }
}

function updateCartQty(input) {
    const url = input.dataset.url;
    const quantity = input.value;

    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "Accept": "application/json",
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ quantity: quantity })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status) {
            const row = input.closest("tr");
            const subtotalElem = row.querySelector(".subtotal");
            if (subtotalElem) {
                subtotalElem.innerText = data.subtotal;
            }

            const totalElem = document.getElementById("total");
            if (totalElem) {
                totalElem.innerText = data.total;
            }

            const cartCount = document.getElementById("cart-count");
            if (cartCount) {
                cartCount.innerText = data.cartCount;
            }

            const totalQuantity = document.getElementById("totalQuantity");
            if (totalQuantity) {
                totalQuantity.innerText = data.cartCount;
            }

            if (typeof Swal !== "undefined") {
                Swal.fire({
                    icon: "success",
                    title: "Đã cập nhật số lượng",
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        }
    })
    .catch(err => console.error("Lỗi cập nhật giỏ hàng:", err));
}
