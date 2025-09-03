# Form Design Utility Classes - Quick Reference

## 🎨 **Utility Classes Overview**

### **Form Structure**
```css
.form-card           /* Main card container with rounded-xl and shadow-md */
.form-card-header    /* Card header with blue gradient background */
.form-card-body      /* Card body with padding */
.form-group          /* Form field group wrapper */
```

### **Form Elements**
```css
.form-input          /* Text input, email, password, etc. */
.form-select         /* Select dropdown */
.form-textarea       /* Textarea with 1 row height */
.form-label          /* Standard label */
.form-label-flex     /* Label with flex layout for icons */
```

### **Layout Grids**
```css
.form-grid-2         /* 2 column responsive grid */
.form-grid-3         /* 3 column responsive grid */
```

### **Buttons**
```css
.btn-primary         /* Primary action button (blue) */
.btn-secondary       /* Secondary button (gray) */
.btn-small           /* Small button for actions */
```

### **Info Boxes**
```css
.info-box            /* Base info box */
.info-box-success    /* Green success message */
.info-box-error      /* Red error message */
.info-box-info       /* Blue info message */
.form-error          /* Red error message for fields */
```

## 🚀 **Quick Usage Examples**

### **Basic Form Card**
```html
<div class="form-card">
    <div class="form-card-header">
        <h2 class="text-sm font-semibold text-white">Form Title</h2>
    </div>
    <div class="form-card-body">
        <!-- Form content -->
    </div>
</div>
```

### **Form Fields**
```html
<div class="form-group">
    <label class="form-label">Field Name</label>
    <input type="text" class="form-input" placeholder="Enter value">
    @error('field')
        <div class="form-error">{{ $message }}</div>
    @enderror
</div>
```

### **Grid Layout**
```html
<div class="form-grid-2">
    <div class="form-group">
        <label class="form-label">First Name</label>
        <input type="text" class="form-input">
    </div>
    <div class="form-group">
        <label class="form-label">Last Name</label>
        <input type="text" class="form-input">
    </div>
</div>
```

### **Buttons**
```html
<div class="flex gap-3 justify-end">
    <a href="#" class="btn-secondary">Cancel</a>
    <button type="submit" class="btn-primary">Save</button>
</div>
```

## 📱 **Responsive Behavior**

- **Desktop**: Full grid layout
- **Tablet**: 2-column max
- **Mobile**: Single column, reduced padding

## 🎯 **Design Principles**

1. **Consistent**: All forms use same classes
2. **Compact**: Reduced padding and spacing
3. **Rounded**: `rounded-xl` for cards, `rounded-lg` for buttons, `rounded-md` for inputs
4. **Clean**: Subtle shadows, no heavy gradients
5. **Accessible**: Proper focus states and contrast

## 📂 **Files Created**

- `resources/css/app.css` - Main CSS with utility classes
- `resources/css/FORM_DESIGN_README.md` - Detailed documentation
- `resources/views/components/form-template.blade.php` - Template for new forms

## 🔧 **Customization**

Override colors in your component:
```css
.form-card-header {
    background: linear-gradient(to right, #your-color, #your-color);
}
```

## ✅ **Migration Checklist**

- [ ] Use `.form-card` instead of custom card classes
- [ ] Replace input classes with `.form-input`
- [ ] Use `.btn-primary` and `.btn-secondary` for buttons
- [ ] Apply `.form-grid-2` or `.form-grid-3` for layouts
- [ ] Use `.info-box-*` for messages
- [ ] Use `.form-error` for validation errors

---

**Result**: Consistent, clean, and compact form design across the entire system! 🎉