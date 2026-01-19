document.querySelectorAll(".btnaccept").forEach(btn => {
    btn.addEventListener("click", () => {
        alert("Order Accepted");
    });
});

document.querySelectorAll(".btnreject").forEach(btn => {
    btn.addEventListener("click", () => {
        alert("Order Rejected");
    });
});
