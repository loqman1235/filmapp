// Generate a random profile picture
import { randProfilePicture } from "./libs/Functions.js";

// const navbar = document.getElementById("navbar");

// if (navbar !== null) {
// 	// Display navbar background on scrolling
// 	window.onscroll = () => {
// 		if (window.scrollY >= 200) {
// 			navbar.style.background = "#1d1d1e";
// 		} else {
// 			navbar.style.background = "none";
// 		}
// 	};
// }

// Profile Dropdown Menu

const profileDropdownBtn = document.getElementById("userProfileDropdownBtn");
const toggleProfileDropdown = () => {
	profileDropdownBtn.classList.toggle("active");
	profileDropdownBtn.nextElementSibling.classList.toggle("active");
};

if (profileDropdownBtn !== null) {
	profileDropdownBtn.addEventListener("click", toggleProfileDropdown);
}
