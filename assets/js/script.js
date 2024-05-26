const loginBox = document.querySelector("#login");
const signupBox = document.querySelector("#signup");
const btn = [
  document.querySelector("#btn-1"),
  document.querySelector("#btn-2"),
];

btn.forEach(
  (el) =>
    (el.onclick = () => {
      const loginInputs = loginBox.querySelectorAll("input");
      loginInputs.forEach(input => input.value = "");

      const signupInputs = signupBox.querySelectorAll("input");
      signupInputs.forEach(input => input.value = "");

      loginBox.classList.toggle("active");
      signupBox.classList.toggle("active");
    })
);
