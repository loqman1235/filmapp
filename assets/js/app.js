// Generate a random profile picture
import { randProfilePicture } from "./libs/Functions.js";

const navbar = document.getElementById("navbar");

if (
	!navbar.nextElementSibling.classList.contains("heroSlider") &&
	!navbar.nextElementSibling.classList.contains("movie_page")
) {
	navbar.style.background = "#1C1F29";
	console.log(navbar.nextElementSibling);
} else {
	if (navbar !== null) {
		// Display navbar background on scrolling
		window.onscroll = () => {
			if (window.scrollY >= 50) {
				navbar.style.background = "#1C1F29";
			} else {
				navbar.style.background =
					"linear-gradient(180deg,rgba(16,20,31,.8) .98%,rgba(16,20,31,.4) 59.23%,rgba(16,20,31,.2) 78.16%,rgba(16,20,31,.0001) 96.12%)";
			}
		};
	}
}

// Profile Dropdown Menu

const profileDropdownBtn = document.getElementById("userProfileDropdownBtn");
const toggleProfileDropdown = () => {
	profileDropdownBtn.classList.toggle("active");
	profileDropdownBtn.nextElementSibling.classList.toggle("active");
};

if (profileDropdownBtn !== null) {
	profileDropdownBtn.addEventListener("click", toggleProfileDropdown);
}
