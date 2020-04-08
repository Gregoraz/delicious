const deliciousShowModal = (clickedElement) => {
  const imageID = clickedElement.getElementsByTagName('img')[0];
  console.log(clickedElement);
  const modal = document.getElementById('myModal');
  const img = clickedElement.getElementsByTagName('img')[0];;
  const modalImg = document.getElementById('modal-content');
  const captionText = document.getElementById('caption');
  modal.style.display = "block";
  modalImg.src = img.getAttribute('src');
  captionText.innerHTML = img.getAttribute('alt');
};

const deliciousHideModal = () => {
  const modal = document.getElementById('myModal');
  modal.style.display = "none";
};

