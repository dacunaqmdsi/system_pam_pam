$(document).ready(function () {
    // Mapping: Category -> Materials
    const categoryMaterials = {
        writingtools: ["Pens", "Pencils", "Markers"],
        paperproducts: ["Notebook", "Printing Paper", "Sticky Notes"],
        organizationtools: ["Folders", "Binders", "Clipboards"],
        storagecontainer: ["File Cabinets", "Storage Boxes", "Desk Organizers"],
        "cutting&gluingtools": ["Scissors", "Glue", "Tape"],
        technologysupplies: ["USB Drive", "Mouse", "Keyboard"],
        "office/schoolequipment": ["Printer", "Projector", "Calculator"],
        miscellaneoussupplies: ["Stapler", "Paper Clips", "Rubber Bands"],
        "health&safety": ["Face Mask", "Hand Sanitizer", "First Aid Kit"]
    };

    // Mapping: Material -> Varieties
    const materialVarieties = {
        // Writing Tools
        Pens: ["Ballpoint", "Gel", "Fountain"],
        Pencils: ["Mechanical", "Wooden", "Colored"],
        Markers: ["Permanent", "Whiteboard", "Highlighter"],

        // Paper Products
        Notebook: ["Spiral", "Composition", "Legal Pad"],
        "Printing Paper": ["A4", "Letter", "Cardstock"],
        "Sticky Notes": ["Standard", "Lined", "Colored"],

        // Organization Tools
        Folders: ["Manila", "Plastic", "Expanding"],
        Binders: ["Ring Binder", "Lever Arch", "Presentation"],
        Clipboards: ["Wooden", "Plastic", "Aluminum"],

        // Storage Containers
        "File Cabinets": ["Metal", "Wood", "Plastic"],
        "Storage Boxes": ["Plastic", "Cardboard", "Collapsible"],
        "Desk Organizers": ["Pen Holder", "Drawer Tray", "Multi-compartment"],

        // Cutting & Gluing Tools
        Scissors: ["Office", "Craft", "Heavy Duty"],
        Glue: ["Stick", "Liquid", "Super Glue"],
        Tape: ["Double-sided", "Masking", "Duct"],

        // Technology Supplies
        "USB Drive": ["8GB", "32GB", "128GB"],
        Mouse: ["Wireless", "Wired", "Gaming"],
        Keyboard: ["Mechanical", "Membrane", "Ergonomic"],

        // Office/School Equipment
        Printer: ["Inkjet", "Laser", "3D Printer"],
        Projector: ["LCD", "DLP", "LED"],
        Calculator: ["Basic", "Scientific", "Graphing"],

        // Miscellaneous Supplies
        Stapler: ["Standard", "Heavy Duty", "Electric"],
        "Paper Clips": ["Small", "Medium", "Large"],
        "Rubber Bands": ["Thin", "Medium", "Thick"],

        // Health & Safety
        "Face Mask": ["Disposable", "Cloth", "N95"],
        "Hand Sanitizer": ["Gel", "Spray", "Foam"],
        "First Aid Kit": ["Basic", "Travel", "Industrial"]
    };

    // Auto-update Material dropdown when Category changes
    $("#add_cat_item").change(function () {
        let category = $(this).val();
        let materials = categoryMaterials[category] || [];
        let materialDropdown = $("#add_material");

        // Clear and populate Material dropdown
        materialDropdown.empty().append('<option value="" selected disabled>Select Material</option>');
        materials.forEach(material => {
            materialDropdown.append(`<option value="${material}">${material}</option>`);
        });

        // Reset Variety dropdown
        $("#add_variety").empty().append('<option value="" selected disabled>Select Variety</option>');
    });

    // Auto-update Variety dropdown when Material changes
    $("#add_material").change(function () {
        let material = $(this).val();
        let varieties = materialVarieties[material] || [];
        let varietyDropdown = $("#add_variety");

        // Clear and populate Variety dropdown
        varietyDropdown.empty().append('<option value="" selected disabled>Select Variety</option>');
        varieties.forEach(variety => {
            varietyDropdown.append(`<option value="${variety}">${variety}</option>`);
        });
    });
});