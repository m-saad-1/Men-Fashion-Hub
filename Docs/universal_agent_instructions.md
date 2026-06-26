# Universal Agent Instructions

Welcome to the FashionHub project. All AI agents working on this repository must read and adhere to these guidelines before executing any changes.

## 1. Architectural Integrity
- **Decoupling Components:** Do not duplicate UI logic (modals, product cards, header logic) across multiple PHP pages. All logic should be encapsulated in global JavaScript files inside `public/assets/js/` (e.g., `header.js`, `footer.js`, `product-card.js`, `modal.js`).
- **API First:** The storefront operates dynamically using API endpoints in `app/api/`. Do not hardcode data arrays (like categories, products, or metadata) directly into PHP template files. Always use `fetch` requests to populate the UI.

## 2. Issue Tracking Protocol
- Every time you fix a bug, complete a feature, or perform significant architectural changes, you **MUST** create a detailed markdown report documenting your work.
- Save this report in the `Docs/issue-tracking/` folder.
- **Naming Convention:** Use descriptive snake_case names for issue files, for example: `issue_fix_wishlist_modal_20260625.md`.
- **Content:** The report must include the problem context, the files modified, the exact changes made, and how to verify the fix.

## 3. UI/UX Consistency
- All product cards across `index.php`, `shop.php`, and `account.php` (wishlist) must be generated using the universal `generateProductCardHtml()` component to ensure design continuity.
- Modals should behave consistently, binding event listeners to clicks outside the modal and correctly mapping the dynamic product data.
- Ensure all styling adjustments are made in `public/assets/css/style.css` globally, preventing inline CSS patches that lead to fragmentation.

## 4. Execution Workflow
- Before making changes, `grep_search` and `view_file` to understand how the components are interconnected.
- Favor `multi_replace_file_content` for precise string manipulations instead of sed scripts.
- Double-check API parameters (authentication states, request bodies, query constraints) to ensure backend handlers expect the payloads you send.

Following these guidelines ensures the storefront remains modular, scalable, and maintainable.
