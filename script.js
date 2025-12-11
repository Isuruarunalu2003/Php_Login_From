const pass = document.getElementById("pass");
const strength = document.getElementById("strength");

pass.addEventListener("input", () => {
    let v = pass.value;
    if (v.length < 6) {
        strength.textContent = "Weak Password ❌";
        strength.style.color = "red";
    } else if (v.match(/[A-Z]/) && v.match(/[0-9]/)) {
        strength.textContent = "Strong Password ✅";
        strength.style.color = "green";
    } else {
        strength.textContent = "Medium Password ⚠️";
        strength.style.color = "orange";
    }
});
