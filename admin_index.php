<?php
require '../header_crud.php';
require '../navbar_crud.php';
require '../section_crud.php';
require '../hobbys_crud.php';
require '../footer_crud.php';
require '../footer_social_crud.php';

// Header data
$headerCRUD = new HeaderCRUD($pdo);
$headers = $headerCRUD->read();

// Navbar data
$navbarCRUD = new NavbarCRUD($pdo);
$navbars = $navbarCRUD->read();

// Section data
$sectionCRUD = new SectionCRUD($pdo);
$sections = $sectionCRUD->read();

// Hobbys data
$hobbyCRUD = new HobbyCRUD($pdo);
$hobbies = $hobbyCRUD->read();

// Footer data
$footerCRUD = new FooterCRUD($pdo);
$footers = $footerCRUD->read();

// Footer Socials data
$footerSocialCRUD = new FooterSocialCRUD($pdo);
$footer_socials = $footerSocialCRUD->readSocials();
$footer_social = !empty($footers) ? $footerSocialCRUD->readSocial($footers[0]['id']) : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>PIBS | UTS</title>
    <link rel="stylesheet" href="../styles.css" />
    <link rel="stylesheet" href="styles.css" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');

            if (status === 'success') {
                alert("Operation completed successfully!");
            } else if (status === 'failure') {
                alert("Operation failed. Please try again.");
            }
        });
    </script>
</head>

<body onload="updateSection(null);">
    <header>
        <div class="header-container">
            <?php if (!empty($headers)) { ?>
                <img class="header-logo" src="../<?= htmlspecialchars($headers[0]['logo']) ?>" alt="Logo">
                <h1><?= htmlspecialchars($headers[0]['title']) ?> | Admin</h1>
            <?php } else { ?>
                <h1></h1>
            <?php } ?>
        </div>
    </header>

    <nav>
        <div class="menu-toggle" onclick="toggleMenu();">&#9776;</div>
        <ul class="navbar">
            <li><a href="#">Header</a></li>
            <li><a href="#">Navbar</a></li>
            <li><a href="#">Section Items</a></li>
            <li><a href="#">Hobbys</a></li>
            <li><a href="#">Footer</a></li>
            <li><a href="#">Footer Socials</a></li>
        </ul>
    </nav>

    <section id="content-section"></section>

    <aside id="form-data">
    </aside>

    <footer>
        <div class="footer-container">
            <div class="social-media">
                <ul class="social-list">
                    <?php foreach ($footer_social as $social) { ?>
                        <li>
                            <img src="../<?= htmlspecialchars($social['icon']) ?>" alt="<?= htmlspecialchars($social['name']) ?>" style="width: 22px; height: 22px;padding-right:6px;" />
                            <a href="<?= htmlspecialchars($social['link']) ?>"><?= htmlspecialchars($social['name']) ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <?php if (!empty($footers)) { ?>
                <div class="copyright">
                    <p>&copy; <?= htmlspecialchars($footers[0]['copyright']) ?>. All Rights Reserved</p>
                </div>

                <div class="website-info">
                    <p><strong><?= htmlspecialchars($headers[0]['title']) ?></strong></p>
                    <p><?= htmlspecialchars($headers[0]['slogan']) ?></p>
                </div>
            <?php } else { ?>
                <p>&copy; Copyright 2024. All Rights Reserved</p>
            <?php } ?>
        </div>
    </footer>
</body>

<script>
    function toggleMenu() {
        const menu = document.querySelector(".navbar");
        menu.classList.toggle("show");
    }

    const navLinks = document.querySelectorAll(".navbar a");
    navLinks.forEach((link) => {
        link.addEventListener("click", function(event) {
            event.preventDefault();
            const sectionId = this.textContent.toLowerCase();
            updateSection(sectionId);
        });
    });

    function updateSection(section) {
        const contentSection = document.getElementById("content-section");
        const formSection = document.getElementById("form-data");
        let content = "";
        let form = "";

        switch (section) {
            case "header":
                content = `
                    <h2>Header</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Logo</th>
                                    <th>Title</th>
                                    <th>Slogan</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($headers as $header): ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><img src="../<?= $header['logo'] ?>" alt="Logo" class="table-img"></td>
                                        <td><?= $header['title'] ?></td>
                                        <td><?= $header['slogan'] ?></td>
                                        <td>
                                            <button type="button" class="btn-edit" onclick="editHeader(<?= $header['id'] ?>, '<?= $header['logo'] ?>', '<?= $header['title'] ?>', '<?= $header['slogan'] ?>')">Edit</button>
                                            <form action="../header_crud.php" method="post" style="display:inline;background:none;box-shadow:none;padding:0;">
                                                <input type="hidden" name="id" value="<?= $header['id'] ?>">
                                                <button type="submit" class="btn-delete" name="action" value="delete" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                `;

                form = `
                    <h3>Add/Edit Header</h3>
                    <form action="../header_crud.php" method="post" class="form-data" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" />
                        <label for="logo">Logo:</label>
                        <input type="file" id="logo" name="logo" accept="image/*">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required />
                        <label for="slogan">Slogan:</label>
                        <input type="text" id="slogan" name="slogan" required />
                        <button type="submit" name="action" value="save">Save</button>
                    </form>
                `;
                break;
            case "navbar":
                content = `
                    <h2>Navbar</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Section</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($navbars as $navbar): ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><?= $navbar['name'] ?></td>
                                        <td><?= $navbar['section'] ?></td>
                                        <td>
                                            <button type="button" class="btn-edit" onclick="editNavbar(<?= $navbar['id'] ?>, '<?= $navbar['name'] ?>', '<?= $navbar['section'] ?>')">Edit</button>
                                            <form action="../navbar_crud.php" method="post" style="display:inline;background:none;box-shadow:none;padding:0;">
                                                <input type="hidden" name="id" value="<?= $navbar['id'] ?>">
                                                <button type="submit" class="btn-delete" name="action" value="delete" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                `;

                form = `
                    <h3>Add/Edit Navbar</h3>
                    <form action="../navbar_crud.php" method="post" class="form-data">
                        <input type="hidden" name="id" id="id" />
                        
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter name" required>
                        
                        <label for="section">Section:</label>
                        <input type="text" id="section" name="section" placeholder="Enter section" required>
                        
                        <button type="submit" name="action" value="save">Save</button>
                    </form>
                `;
                break;
            case "section items":
                content = `
                    <h2>Section Items</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Section Name</th>
                                    <th>Label</th>
                                    <th>Value</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($sections as $section): ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><?= $section['section_name'] ?></td>
                                        <td><?= $section['label'] ?></td>
                                        <td><?= $section['value'] ?></td>
                                        <td>
                                            <button type="button" class="btn-edit" onclick="editItem(<?= $section['id'] ?>, '<?= $section['label'] ?>', '<?= $section['value'] ?>', '<?= $section['id_navbar'] ?>')">Edit</button>
                                            <form action="../section_crud.php" method="post" style="display:inline;background:none;box-shadow:none;padding:0;">
                                                <input type="hidden" name="id" value="<?= $section['id'] ?>">
                                                <button type="submit" class="btn-delete" name="action" value="delete" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                `;

                form = `
                    <h3>Add/Edit Section Item</h3>
                    <form action="../section_crud.php" method="post" class="form-data">
                        <input type="hidden" name="id" id="id" />
                        <label for="section_id">Section:</label>
                        <select id="section_id" name="section_id" required>
                            <option value="">Select Section</option>
                            <?php foreach ($sectionCRUD->getNavbarOptions() as $option): ?>
                                <option value="<?= $option['id'] ?>"><?= $option['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="label">Label:</label>
                        <input type="text" id="label" name="label" placeholder="Enter label" required>
                        <label for="value">Value:</label>
                        <input type="text" id="value" name="value" placeholder="Enter value" required>
                        <button type="submit" name="action" value="save">Save</button>
                    </form>
                `;
                break;
            case "hobbys":
                content = `
                    <h2>Hobbies</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($hobbies as $hobby): ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><?= $hobby['name'] ?></td>
                                        <td><img src="../<?= $hobby['icon'] ?>" alt="Icon" class="table-img"></td>
                                        <td>
                                            <button type="button" class="btn-edit" onclick="editHobby(<?= $hobby['id'] ?>, '<?= $hobby['name'] ?>', '<?= $hobby['icon'] ?>')">Edit</button>
                                            <form action="../hobbys_crud.php" method="post" style="display:inline;background:none;box-shadow:none;padding:0;">
                                                <input type="hidden" name="id" value="<?= $hobby['id'] ?>">
                                                <button type="submit" class="btn-delete" name="action" value="delete" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                `;

                form = `
                    <h3>Add/Edit Hobby</h3>
                    <form action="../hobbys_crud.php" method="post" class="form-data" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" />
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required />
                        <label for="icon">Icon:</label>
                        <input type="file" id="icon" name="icon" accept="image/*" />
                        <button type="submit" name="action" value="save">Save</button>
                    </form>
                `;
                break;
            case "footer":
                content = `
                    <h2>Footer</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Copyright</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($footers as $footer): ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><?= $footer['copyright'] ?></td>
                                        <td>
                                            <button type="button" class="btn-edit" onclick="editFooter(<?= $footer['id'] ?>, '<?= $footer['copyright'] ?>')">Edit</button>
                                            <form action="../footer_crud.php" method="post" style="display:inline;background:none;box-shadow:none;padding:0;">
                                                <input type="hidden" name="id" value="<?= $footer['id'] ?>">
                                                <button type="submit" class="btn-delete" name="action" value="delete" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                `;

                form = `
                    <h3>Add/Edit Footer</h3>
                    <form action="../footer_crud.php" method="post" class="form-data">
                        <input type="hidden" name="id" id="id" />
                        <label for="copyright">Copyright:</label>
                        <input type="text" id="copyright" name="copyright" />
                        <button type="submit" name="action" value="save">Save</button>
                    </form>
                `;
                break;
            case "footer socials":
                content = `
                    <h2>Footer Socials</h2>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Copyright</th>
                                    <th>Name</th>
                                    <th>Link</th>
                                    <th>Icon</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $counter = 1;
                                foreach ($footer_socials as $social): ?>
                                    <tr>
                                        <td><?= $counter++ ?></td>
                                        <td><?= $social['copyright'] ?></td>
                                        <td><?= $social['name'] ?></td>
                                        <td><?= $social['link'] ?></td>
                                        <td><img src="../<?= $social['icon'] ?>" alt="Icon" class="table-img"></td>
                                        <td>
                                            <button type="button" class="btn-edit" onclick="editFooterSocial(<?= $social['id'] ?>, '<?= $social['footer_id'] ?>', '<?= $social['name'] ?>', '<?= $social['link'] ?>')">Edit</button>
                                            <form action="../footer_social_crud.php" method="post" style="display:inline;background:none;box-shadow:none;padding:0;">
                                                <input type="hidden" name="id" value="<?= $social['id'] ?>">
                                                <button type="submit" class="btn-delete" name="action" value="delete" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                `;

                form = `
                    <h3>Add/Edit Footer Social</h3>
                    <form action="../footer_social_crud.php" method="post" class="form-data" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" />
                        <label for="footer_id">Footer ID:</label>
                        <select id="footer_id" name="footer_id" required>
                            <option value="">Select Footer</option>
                            <?php foreach ($footerSocialCRUD->getFooterOptions() as $option): ?>
                                <option value="<?= $option['id'] ?>"><?= $option['copyright'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" placeholder="Enter name" required>
                        <label for="link">Link:</label>
                        <input type="url" id="link" name="link" placeholder="Enter link" required>
                        <label for="icon">Icon:</label>
                        <input type="file" id="icon" name="icon" accept="image/*" />
                        <button type="submit" name="action" value="save">Save</button>
                    </form>
                `;
                break;
            default:
                content = "<p>Choose a section to manage its content.</p>";
        }

        contentSection.innerHTML = content;
        formSection.innerHTML = form;
    }

    function editHeader(id, logo, title, slogan) {
        document.getElementById("id").value = id;
        document.getElementById("title").value = title;
        document.getElementById("slogan").value = slogan;
    }

    function editNavbar(id, name, section) {
        document.getElementById('id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('section').value = section;
    }

    function editItem(id, label, value, sectionId) {
        document.getElementById('id').value = id;
        document.getElementById('label').value = label;
        document.getElementById('value').value = value;
        document.getElementById('section_id').value = sectionId;
    }

    function editHobby(id, name, icon) {
        document.getElementById('id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('icon').value = icon;
    }

    function editFooter(id, copyright) {
        document.getElementById('id').value = id;
        document.getElementById('copyright').value = copyright;
    }

    function editFooterSocial(id, footerId, name, link) {
        document.getElementById('id').value = id;
        document.getElementById('footer_id').value = footerId;
        document.getElementById('name').value = name;
        document.getElementById('link').value = link;
    }
</script>

</html>
