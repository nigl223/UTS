<?php
require 'header_crud.php';
require 'navbar_crud.php';
require 'section_crud.php';
require 'hobbys_crud.php';
require 'footer_crud.php';
require 'footer_social_crud.php';

// Header data
$headerCRUD = new HeaderCRUD($pdo);
$headers = $headerCRUD->read();

// Navbar data
$navbarCRUD = new NavbarCRUD($pdo);
$navbars = $navbarCRUD->read();

// Section data
$sectionCRUD = new SectionCRUD($pdo);
$sectionData = [];
foreach ($navbars as $section) {
  $items = $sectionCRUD->readItems($section['id']);
  $sectionData[$section['section']] = $items;
}

// Hobbies data
$hobbyCRUD = new HobbyCRUD($pdo);
$hobbies = $hobbyCRUD->read();

// Footer data
$footerCRUD = new FooterCRUD($pdo);
$footers = $footerCRUD->read();

// Footer Social data
$footerSocialCRUD = new FooterSocialCRUD($pdo);
$footer_social = !empty($footers) ? $footerSocialCRUD->readSocial($footers[0]['id']) : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>PIBS | UTS</title>
  <link rel="stylesheet" href="styles.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body onload="updateSection(null);">
  <header>
    <div class="header-container">
      <?php if (!empty($headers)) { ?>
        <img class="header-logo" src="<?= htmlspecialchars($headers[0]['logo']) ?>" alt="Logo">
        <h1><?= htmlspecialchars($headers[0]['title']) ?></h1>
      <?php } else { ?>
        <h1></h1>
      <?php } ?>
    </div>
  </header>

  <nav>
    <div class="menu-toggle" onclick="toggleMenu();">&#9776;</div>
    <ul class="navbar">
      <?php foreach ($navbars as $navbar) { ?>
        <li><a href="#"><?= htmlspecialchars($navbar['name']) ?></a></li>
      <?php } ?>
    </ul>
  </nav>

  <section id="content-section"></section>

  <aside>
    <h3>Hobi</h3>
    <ul class="hobi-list">
      <ul>
        <?php foreach ($hobbies as $hobby): ?>
          <li>
            <img src="<?= htmlspecialchars($hobby['icon']) ?>" alt="<?= htmlspecialchars($hobby['name']) ?>" style="width: 22px; height: 22px;" />
            <a href="#"><?= htmlspecialchars($hobby['name']) ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </ul>
  </aside>

  <footer>
    <div class="footer-container">
      <div class="social-media">
        <ul class="social-list">
          <?php foreach ($footer_social as $social) { ?>
            <li>
              <img src="<?= htmlspecialchars($social['icon']) ?>" alt="<?= htmlspecialchars($social['name']) ?>" style="width: 22px; height: 22px;padding-right:6px;" />
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
  const sectionData = <?= json_encode($sectionData, JSON_PRETTY_PRINT) ?>;
  console.log(sectionData);

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
    let content = "";

    if (section && sectionData[section]) {
      content = `
      <article>
        <h2>${section.charAt(0).toUpperCase() + section.slice(1)}</h2>
        <ul class="content-list">
          ${sectionData[section]
            .map(
              (item) =>
                `<li><strong>${item.label}: </strong>${item.value}</li>`
            )
            .join("")}
        </ul>
      </article>
    `;
    } else {
      content = `
      <article>
        <h2>Welcome</h2>
        <p>Please select a section.</p>
      </article>
    `;
    }

    contentSection.innerHTML = content;
  }
</script>

</html>
