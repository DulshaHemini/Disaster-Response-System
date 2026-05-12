# DRCS CSS Architecture

## File Structure

```
public/assets/css/
├── theme.css       # Global theme & common styles (LOAD FIRST)
├── navbar.css      # Navbar component styles
├── ticker.css      # Ticker component styles
├── home.css        # Home page specific styles
└── tracker.css     # Tracker page specific styles
```

## Usage

### Always import `theme.css` first in your HTML:

```html
<!-- Theme CSS must be loaded first -->
<link rel="stylesheet" href="assets/css/theme.css"/>
<link rel="stylesheet" href="assets/css/navbar.css"/>
<link rel="stylesheet" href="assets/css/home.css"/>
```

## What's in theme.css?

### 1. CSS Custom Properties (Variables)
- **Colors**: `--red`, `--red-dk`, `--red-lt`, `--amber`, `--green`, `--blue`, etc.
- **Typography**: `--font-hd`, `--font-bd`, `--font-mn`
- **Spacing**: `--spacing-xs` through `--spacing-2xl`
- **Shadows**: `--shadow-sm` through `--shadow-xl`
- **Transitions**: `--transition-fast`, `--transition-base`, `--transition-slow`

### 2. Global Reset
- Box-sizing, margin, padding reset
- Smooth scrolling
- Font smoothing

### 3. Typography
- Heading styles (h1-h6)
- Paragraph and link styles

### 4. Button Classes
- `.btn`, `.btn-lg`, `.btn-sm`
- `.btn-primary`, `.btn-secondary`, `.btn-outline`, `.btn-ghost`
- `.btn-success`, `.btn-danger`

### 5. Form Elements
- Input, select, textarea styling
- Labels and form groups
- Focus states

### 6. Cards
- `.card`, `.card-header`, `.card-body`, `.card-footer`

### 7. Badges
- `.badge`, `.badge-primary`, `.badge-success`, `.badge-warning`, `.badge-info`, `.badge-muted`

### 8. Utility Classes
- **Spacing**: `.mt-1`, `.mb-2`, `.p-3`, etc.
- **Text**: `.text-center`, `.text-primary`, `.text-muted`
- **Background**: `.bg-white`, `.bg-primary`, `.bg-surface`
- **Display**: `.d-flex`, `.d-grid`, `.d-none`
- **Flex**: `.justify-center`, `.align-center`, `.gap-2`
- **Borders**: `.border`, `.rounded`, `.rounded-lg`
- **Shadows**: `.shadow`, `.shadow-lg`

### 9. Animations
- `.fade-up`, `.reveal`, `.pulse-dot`, `.ping`, `.spin`

### 10. Common Components
- Modal styles
- Toast notifications
- Loading spinners
- Scrollbar styling

## Color Theme

### Primary Colors
```css
--red:     #c8102e  /* Primary brand color */
--red-dk:  #9b0b21  /* Darker red for hovers */
--red-lt:  #fbeaec  /* Light red for backgrounds */
--red-m:   #f5c0c7  /* Medium red for borders */
```

### Accent Colors
```css
--amber:   #d97706  /* Warning/caution */
--green:   #15803d  /* Success/positive */
--blue:    #1d4ed8  /* Info/neutral */
```

### Neutral Colors
```css
--white:   #ffffff
--off:     #f8f5f2  /* Off-white background */
--surface: #f2ede8  /* Surface/card background */
--text:    #1a1a1a  /* Primary text */
--muted:   #6b6b6b  /* Secondary text */
--border:  #e2ddd8  /* Border color */
```

## Modifying the Theme

To change colors across the entire application, edit the CSS custom properties in `theme.css`:

```css
:root {
  --red: #your-new-color;
  /* Other variables... */
}
```

All components will automatically use the updated colors.

## Best Practices

1. **Always use CSS variables** instead of hardcoded colors
2. **Use utility classes** for common patterns (spacing, flex, etc.)
3. **Keep component-specific styles** in their own files
4. **Don't duplicate** styles that exist in theme.css
5. **Import theme.css first** in every page

## Example Usage

```html
<!-- Button examples -->
<button class="btn btn-primary">Primary Action</button>
<button class="btn btn-outline">Secondary Action</button>
<button class="btn btn-sm btn-success">Small Success</button>

<!-- Badge examples -->
<span class="badge badge-primary">New</span>
<span class="badge badge-success">Active</span>

<!-- Utility classes -->
<div class="d-flex justify-between align-center gap-2 p-3">
  <h3 class="text-primary mb-2">Title</h3>
  <button class="btn btn-sm">Action</button>
</div>

<!-- Card example -->
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Card Title</h4>
  </div>
  <div class="card-body">
    <p>Card content goes here</p>
  </div>
</div>
```

## Responsive Design

Theme includes responsive utilities:
- `.hide-md` - Hidden on tablets and below
- `.hide-sm` - Hidden on mobile

Breakpoints:
- Mobile: max-width 560px
- Tablet: max-width 900px
- Desktop: above 900px
