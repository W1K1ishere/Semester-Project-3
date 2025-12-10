document.querySelectorAll(".splitUp").forEach(element => {
    const letters = element.innerText.trim().split("");

    element.innerHTML = letters.map((letter, i) => `<span style="--i:${i}">${letter}</span>`).join("");
});

document.querySelectorAll(".splitDown").forEach(element => {
    const letters = element.innerText.trim().split("");

    element.innerHTML = letters.map((letter, i) => `<span style="--i:${i}">${letter}</span>`).join("");
});
