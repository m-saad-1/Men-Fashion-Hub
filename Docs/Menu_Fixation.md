The Header Categories Mega Menu is still broken. Do not adjust padding, margins, widths, or spacing randomly. Find and fix the actual positioning issue.

Current Problem:

* The mega menu opens shifted toward the right side.
* Part of the menu goes outside the viewport.
* The right side of the menu is cut off by the screen edge.
* The dropdown is not centered relative to the browser window.

Required Fix:

* The mega menu container must be horizontally centered within the viewport.
* The left and right margins must be equal.
* The entire dropdown must always remain visible inside the screen.
* No content should overflow beyond the left or right edge of the browser.
* The menu should open directly below the Categories navigation item while remaining centered on the screen.

Implementation Requirements:

* Inspect the parent containers and positioning logic.
* Check for incorrect use of:

  * left
  * right
  * margin-left
  * margin-right
  * transform
  * translateX
  * absolute positioning
  * container width restrictions
* Remove any positioning that pushes the menu outside the viewport.
* Use a proper centering approach so the dropdown is centered relative to the viewport, not relative to a narrow parent container.

Validation:

* Test on 1920px, 1440px, 1366px, and 1280px widths.
* Verify the menu is fully visible.
* Verify equal spacing on both sides.
* Verify no horizontal scrolling appears.
* Verify the dropdown remains centered after page refresh.
* Do not mark this task complete until the entire mega menu is visible and perfectly centered on screen.

Expected Result:
When Categories is opened, the mega menu should appear as a large professional full-width dropdown with equal space on the left and right sides, fully visible within the viewport, with no clipping, overflow, or hidden content.
