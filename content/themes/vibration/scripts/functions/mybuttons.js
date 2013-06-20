// Grid System
(function() {
    tinymce.create('tinymce.plugins.gridsystem', {
        init : function(ed, url) {
            ed.addButton('gridsystem', {
                title : 'Grid System',
                image : url+'/gridsystem.png',
                onclick : function() {
                     ed.selection.setContent('[gridsystem]' + ed.selection.getContent() + '[/gridsystem]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('gridsystem', tinymce.plugins.gridsystem);
})();

// One Half
(function() {
    tinymce.create('tinymce.plugins.one_half', {
        init : function(ed, url) {
            ed.addButton('one_half', {
                title : 'One Half',
                image : url+'/one_half.png',
                onclick : function() {
                     ed.selection.setContent('[one_half]' + ed.selection.getContent() + '[/one_half]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_half', tinymce.plugins.one_half);
})();
// One Third
(function() {
    tinymce.create('tinymce.plugins.one_third', {
        init : function(ed, url) {
            ed.addButton('one_third', {
                title : 'One Third',
                image : url+'/one_third.png',
                onclick : function() {
                     ed.selection.setContent('[one_third]' + ed.selection.getContent() + '[/one_third]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_third', tinymce.plugins.one_third);
})();
// One Fourth
(function() {
    tinymce.create('tinymce.plugins.one_fourth', {
        init : function(ed, url) {
            ed.addButton('one_fourth', {
                title : 'One Fourth',
                image : url+'/one_fourth.png',
                onclick : function() {
                     ed.selection.setContent('[one_fourth]' + ed.selection.getContent() + '[/one_fourth]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('one_fourth', tinymce.plugins.one_fourth);
})();
// Two Thirds
(function() {
    tinymce.create('tinymce.plugins.two_thirds', {
        init : function(ed, url) {
            ed.addButton('two_thirds', {
                title : 'Two Thirds',
                image : url+'/two_thirds.png',
                onclick : function() {
                     ed.selection.setContent('[two_thirds]' + ed.selection.getContent() + '[/two_thirds]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('two_thirds', tinymce.plugins.two_thirds);
})();
// Three Fourths
(function() {
    tinymce.create('tinymce.plugins.three_fourths', {
        init : function(ed, url) {
            ed.addButton('three_fourths', {
                title : 'Three Fourths',
                image : url+'/three_fourths.png',
                onclick : function() {
                     ed.selection.setContent('[three_fourths]' + ed.selection.getContent() + '[/three_fourths]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('three_fourths', tinymce.plugins.three_fourths);
})();

// Blog Posts
(function() {
    tinymce.create('tinymce.plugins.blogposts', {
        init : function(ed, url) {
            ed.addButton('blogposts', {
                title : 'Blog Posts',
                image : url+'/blogposts.png',
                onclick : function() {
                     ed.selection.setContent('[blogposts columns="one_fourth" post_per_page="4"]' + ed.selection.getContent() + '[/blogposts]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('blogposts', tinymce.plugins.blogposts);
})();

// Portfolio Post's
(function() {
    tinymce.create('tinymce.plugins.portfolio', {
        init : function(ed, url) {
            ed.addButton('portfolio', {
                title : 'Portfolio Post\'s',
                image : url+'/portfolio.png',
                onclick : function() {
                     ed.selection.setContent('[portfolio]' + ed.selection.getContent() + '[/portfolio]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('portfolio', tinymce.plugins.portfolio);
})();

// Team Member
(function() {
    tinymce.create('tinymce.plugins.team_member', {
        init : function(ed, url) {
            ed.addButton('team_member', {
                title : 'Team Member',
                image : url+'/team_member.png',
                onclick : function() {
                     ed.selection.setContent('[one_fourth][team_member image_url="image-url" name="John Doe" position="Ceo/Owner" linkedin_url="#" facebook_url="#" twitter_url="#"]' + ed.selection.getContent() + '[/team_member][/one_fourth]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('team_member', tinymce.plugins.team_member);
})();

// Pricing Table
(function() {
    tinymce.create('tinymce.plugins.pricing_table', {
        init : function(ed, url) {
            ed.addButton('pricing_table', {
                title : 'Pricing Table',
                image : url+'/pricing_table.png',
                onclick : function() {
                     ed.selection.setContent('[pricing_table price="$120" features="Example Feature 1,Example Feature 2,Example Feature 1" button_link="#" heading="Classic"]' + ed.selection.getContent() + '[/pricing_table]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('pricing_table', tinymce.plugins.pricing_table);
})();

// Column Box
(function() {
    tinymce.create('tinymce.plugins.columnbox', {
        init : function(ed, url) {
            ed.addButton('columnbox', {
                title : 'Column Box',
                image : url+'/columnbox.png',
                onclick : function() {
                     ed.selection.setContent('[columnbox url="#" image="img-url" title="Title"]' + ed.selection.getContent() + '[/columnbox]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('columnbox', tinymce.plugins.columnbox);
})();

// Slogan
(function() {
    tinymce.create('tinymce.plugins.slogan', {
        init : function(ed, url) {
            ed.addButton('slogan', {
                title : 'Slogan',
                image : url+'/slogan.png',
                onclick : function() {
                     ed.selection.setContent('[slogan heading="Heading" subheading="Sub Heading" first_button_text="First Button" first_button_link="#" second_button_text="Second Button" second_button_link="#"]' + ed.selection.getContent() + '[/slogan]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('slogan', tinymce.plugins.slogan);
})();

// Accordions
(function() {
    tinymce.create('tinymce.plugins.accordions', {
        init : function(ed, url) {
            ed.addButton('accordions', {
                title : 'Accordions',
                image : url+'/accordions.png',
                onclick : function() {
                     ed.selection.setContent('[accordions]' + ed.selection.getContent() + '[/accordions]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('accordions', tinymce.plugins.accordions);
})();
// Accordion Item
(function() {
    tinymce.create('tinymce.plugins.accordion_item', {
        init : function(ed, url) {
            ed.addButton('accordion_item', {
                title : 'Accordion Item',
                image : url+'/accordions_item.png',
                onclick : function() {
                     ed.selection.setContent('[accordion_item title="Accordion Item Title"]Some content for your accordion.' + ed.selection.getContent() + '[/accordion_item]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('accordion_item', tinymce.plugins.accordion_item);
})();
// Toggles
(function() {
    tinymce.create('tinymce.plugins.toggles', {
        init : function(ed, url) {
            ed.addButton('toggles', {
                title : 'Toggles',
                image : url+'/toggles.png',
                onclick : function() {
                     ed.selection.setContent('[toggles]' + ed.selection.getContent() + '[/toggles]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('toggles', tinymce.plugins.toggles);
})();
// Toggle Item
(function() {
    tinymce.create('tinymce.plugins.toggle_item', {
        init : function(ed, url) {
            ed.addButton('toggle_item', {
                title : 'Toggle Item',
                image : url+'/toggle_item.png',
                onclick : function() {
                     ed.selection.setContent('[toggle_item title="Toggle Item Title"]Some content for your toggle.' + ed.selection.getContent() + '[/toggle_item]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('toggle_item', tinymce.plugins.toggle_item);
})();
// Testimonials
(function() {
    tinymce.create('tinymce.plugins.testimonials', {
        init : function(ed, url) {
            ed.addButton('testimonials', {
                title : 'Testimonials',
                image : url+'/testimonials.png',
                onclick : function() {
                     ed.selection.setContent('[testimonials]' + ed.selection.getContent() + '[/testimonials]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('testimonials', tinymce.plugins.testimonials);
})();
// Button
(function() {
    tinymce.create('tinymce.plugins.button', {
        init : function(ed, url) {
            ed.addButton('button', {
                title : 'Button',
                image : url+'/button.png',
                onclick : function() {
                     ed.selection.setContent('[button link="URL-HERE" background="ababab" size="20" link_color="ffffff"]Custom Button' + ed.selection.getContent() + '[/button]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('button', tinymce.plugins.button);
})();
// Tabs
(function() {
    tinymce.create('tinymce.plugins.tabs', {
        init : function(ed, url) {
            ed.addButton('tabs', {
                title : 'Tabs',
                image : url+'/tabs.png',
                onclick : function() {
                     ed.selection.setContent('[tabs titles="Content 1, Content 2, Content 3"] [showtab id="Content 1"] Content Area 1 [/showtab] [showtab id="Content 2"] Content Area 2 [/showtab] [showtab id="Content 3"] Content Area 3 [/showtab]' + ed.selection.getContent() + '[/tabs]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('tabs', tinymce.plugins.tabs);
})();
//Slideshow
(function() {
    tinymce.create('tinymce.plugins.slideshow', {
        init : function(ed, url) {
            ed.addButton('slideshow', {
                title : 'Slideshow',
                image : url+'/slideshow.png',
                onclick : function() {
                     ed.selection.setContent('[slideshow][slideshow_item url="IMG-URL"][/slideshow_item][slideshow_item url="IMG-URL"][/slideshow_item][slideshow_item url="IMG-URL"][/slideshow_item]' + ed.selection.getContent() + '[/slideshow]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('slideshow', tinymce.plugins.slideshow);
})();
//Info Box
(function() {
    tinymce.create('tinymce.plugins.infobox', {
        init : function(ed, url) {
            ed.addButton('infobox', {
                title : 'Info Box',
                image : url+'/infobox.png',
                onclick : function() {
                     ed.selection.setContent('[info_box]This is where your content goes' + ed.selection.getContent() + '[info_box]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('infobox', tinymce.plugins.infobox);
})();
//Icon Holder
(function() {
    tinymce.create('tinymce.plugins.iconholder', {
        init : function(ed, url) {
            ed.addButton('iconholder', {
                title : 'Icon Holder',
                image : url+'/iconholder.png',
                onclick : function() {
                     ed.selection.setContent('[iconholder icon="eye" type="circle"]<h3>Heading</h3><p>You can put content here.</p>' + ed.selection.getContent() + '[/iconholder]');
 
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('iconholder', tinymce.plugins.iconholder);
})();