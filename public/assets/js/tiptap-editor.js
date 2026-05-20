import { Editor } from 'https://esm.sh/@tiptap/core@2.6.6';
import StarterKit from 'https://esm.sh/@tiptap/starter-kit@2.6.6';
import Link from 'https://esm.sh/@tiptap/extension-link@2.6.6';
import Image from 'https://esm.sh/@tiptap/extension-image@2.6.6';
import Placeholder from 'https://esm.sh/@tiptap/extension-placeholder@2.6.6';

const editorEl = document.querySelector('#editor');
const hiddenInput = document.querySelector('#conteudo-hidden');
const toolbar = document.querySelector('#toolbar');

function getCsrfToken() {
    const input = document.querySelector('input[name="_csrf_token"]');
    return input ? input.value : '';
}

async function uploadImage(file) {
    const formData = new FormData();
    formData.append('imagem', file);
    formData.append('_csrf_token', getCsrfToken());

    const res = await fetch('/admin/upload-imagem', {
        method: 'POST',
        body: formData,
    });

    const data = await res.json();
    if (data.error) {
        alert(data.error);
        return null;
    }
    return data.url;
}

if (editorEl && hiddenInput) {
    const editor = new Editor({
        element: editorEl,
        extensions: [
            StarterKit.configure({
                heading: { levels: [2, 3] },
            }),
            Link.configure({
                openOnClick: false,
                HTMLAttributes: { target: '_blank' },
            }),
            Image,
            Placeholder.configure({
                placeholder: 'Comece a escrever...',
            }),
        ],
        content: hiddenInput.value || '',
        onUpdate({ editor }) {
            hiddenInput.value = editor.getHTML();
        },
        editorProps: {
            handleDrop(view, event) {
                const files = event.dataTransfer?.files;
                if (files && files.length > 0) {
                    const file = files[0];
                    if (file.type.startsWith('image/')) {
                        event.preventDefault();
                        uploadImage(file).then((url) => {
                            if (url) {
                                editor.chain().focus().setImage({ src: url }).run();
                            }
                        });
                        return true;
                    }
                }
                return false;
            },
            handlePaste(view, event) {
                const items = event.clipboardData?.items;
                if (items) {
                    for (const item of items) {
                        if (item.type.startsWith('image/')) {
                            event.preventDefault();
                            const file = item.getAsFile();
                            uploadImage(file).then((url) => {
                                if (url) {
                                    editor.chain().focus().setImage({ src: url }).run();
                                }
                            });
                            return true;
                        }
                    }
                }
                return false;
            },
        },
    });

    // Sync on form submit
    const form = editorEl.closest('form');
    if (form) {
        form.addEventListener('submit', () => {
            hiddenInput.value = editor.getHTML();
        });
    }

    // Toolbar actions
    if (toolbar) {
        toolbar.addEventListener('click', (e) => {
            const btn = e.target.closest('button');
            if (!btn) return;

            const action = btn.dataset.action;
            const level = btn.dataset.level ? parseInt(btn.dataset.level) : null;

            switch (action) {
                case 'bold':
                    editor.chain().focus().toggleBold().run();
                    break;
                case 'italic':
                    editor.chain().focus().toggleItalic().run();
                    break;
                case 'strike':
                    editor.chain().focus().toggleStrike().run();
                    break;
                case 'heading':
                    editor.chain().focus().toggleHeading({ level }).run();
                    break;
                case 'bulletList':
                    editor.chain().focus().toggleBulletList().run();
                    break;
                case 'orderedList':
                    editor.chain().focus().toggleOrderedList().run();
                    break;
                case 'link': {
                    const url = prompt('URL do link:');
                    if (url) {
                        editor.chain().focus().setLink({ href: url }).run();
                    } else {
                        editor.chain().focus().unsetLink().run();
                    }
                    break;
                }
                case 'image': {
                    const input = document.createElement('input');
                    input.type = 'file';
                    input.accept = 'image/*';
                    input.onchange = async () => {
                        const file = input.files[0];
                        if (file) {
                            const url = await uploadImage(file);
                            if (url) {
                                editor.chain().focus().setImage({ src: url }).run();
                            }
                        }
                    };
                    input.click();
                    break;
                }
                case 'undo':
                    editor.chain().focus().undo().run();
                    break;
                case 'redo':
                    editor.chain().focus().redo().run();
                    break;
            }

            updateToolbarState();
        });

        function updateToolbarState() {
            toolbar.querySelectorAll('button').forEach((btn) => {
                const action = btn.dataset.action;
                const level = btn.dataset.level ? parseInt(btn.dataset.level) : null;
                let isActive = false;

                switch (action) {
                    case 'bold': isActive = editor.isActive('bold'); break;
                    case 'italic': isActive = editor.isActive('italic'); break;
                    case 'strike': isActive = editor.isActive('strike'); break;
                    case 'heading': isActive = editor.isActive('heading', { level }); break;
                    case 'bulletList': isActive = editor.isActive('bulletList'); break;
                    case 'orderedList': isActive = editor.isActive('orderedList'); break;
                    case 'link': isActive = editor.isActive('link'); break;
                }

                btn.classList.toggle('is-active', isActive);
            });
        }

        editor.on('selectionUpdate', updateToolbarState);
        editor.on('update', updateToolbarState);
    }
}
