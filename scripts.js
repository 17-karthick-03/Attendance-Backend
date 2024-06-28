document.addEventListener("DOMContentLoaded", function () {
  const popupContainer = document.getElementById("popupContainer");
  const popupContent = document.getElementById("popupContent");
  const backgroundBlur = document.getElementById("backgroundBlur");
  const container = document.getElementById("formContainer");
  const closePopupButton = document.getElementById("closePopup");

  backgroundBlur.style.opacity = "0.8";
  setTimeout(() => {
    backgroundBlur.style.opacity = "0";
    container.style.display = "block";
    setTimeout(() => {
      showPopup("This attendance percentage was actually correct according to the attendance sheet that I handle every day with subject staff. However, in the master attendance, the possibility is that you should get an attendance percentage of more than 0.5 to 1% compared to this.");
    }, 1000);
  }, 1000);

  closePopupButton.addEventListener("click", closePopup);

  function closePopup() {
    popupContainer.style.display = "none";
  }

  function showPopup(message) {
    popupContent.innerHTML = `<p>${message}</p>`;
    popupContent.innerHTML += `<button style="background: linear-gradient(to right, #FF6F61, #6E8B9E); border-radius: 15px" id="agreeButton">Agree and Continue</button>`;
    
    const agreeButton = document.getElementById("agreeButton");
    agreeButton.addEventListener("click", function () {
      closePopup();
      closeTab();
    });

    popupContainer.style.display = "flex";
  }

  function closeTab() {
    window.close(); // This function will close the current tab or window
  }
});
