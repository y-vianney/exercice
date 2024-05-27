const loginBox = document.querySelector("#login");
const signupBox = document.querySelector("#signup");
const btn = [
  document.querySelector("#btn-1"),
  document.querySelector("#btn-2"),
];

btn.forEach(
  (el) =>
    (el.onclick = () => {
      loginBox.classList.toggle("active");
      signupBox.classList.toggle("active");
    })
);
