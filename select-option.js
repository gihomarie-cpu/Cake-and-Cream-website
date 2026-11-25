// Select option form submission - thank you message section
document.addEventListener("DOMContentLoaded", function () {
  const orderForm = document.getElementById("order-form");
  const orderMessage = document.getElementById("order-message");

  if (!orderForm || !orderMessage) {
    return;
  }

  orderForm.addEventListener("submit", async function (event) {
    event.preventDefault();

    orderMessage.textContent = "Submitting your order...";
    orderMessage.className = "order-message order-message--pending";

    try {
      const response = await fetch(orderForm.action, {
        method: "POST",
        body: new FormData(orderForm),
        headers: {
          "X-Requested-With": "XMLHttpRequest",
        },
      });

      const result = await response.json().catch(() => null);

      if (response.ok && result && result.success) {
        orderMessage.textContent = "Thank you! Your order has been received successfully.";
        orderMessage.className = "order-message order-message--success";
        orderForm.reset();
      } else {
        const errorText = result && result.message ? result.message : "Sorry, your order could not be submitted. Please try again.";
        orderMessage.textContent = errorText;
        orderMessage.className = "order-message order-message--error";
      }
    } catch (error) {
      orderMessage.textContent = "Sorry, there was a network error while submitting your order. Please try again.";
      orderMessage.className = "order-message order-message--error";
    }
  });
});
