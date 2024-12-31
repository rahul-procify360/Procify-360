import AhetoTemplateManager from '@library/Manager'

(function ($) {
    $(() => {
        window.ahetoTemplateManager = new AhetoTemplateManager
        window.ahetoTemplateManager.init()

        const template = $('#tmpl-elementor-add-section')
        if (template.length > 0) {
            template.text(
                template.text()
                    .replace('<div class="elementor-add-section-drag-title', '<div class="elementor-add-section-area-button elementor-add-aheto-button" style="background-color: #6d7882;" title="Aheto Elements"> <i class="eicon-folder"></i> </div><div class="elementor-add-section-drag-title')
            )

            elementor.on('preview:loaded', function () {
                $(elementor.$previewContents[0].body).on('click', '.elementor-add-aheto-button', function (event) {
                    event.preventDefault()

                    const button = $(this)
                    const wrap = button.closest('.elementor-section-wrap')
                    let inside = false
                    let position = elementor.getPreviewView().model.get('elements').length
                    if (wrap.length > 0) {
                        inside = true
                        position = button.closest('.elementor-add-section').index()
                    }

                    $e.run(
                        'ahetolibrary/open',
                        {
                            importOptions: {
                                inside,
                                at: position,
                            },
                        }
                    )
                })
            })
        }
    });
}(jQuery))
