import zipfile
import xml.sax.saxutils as saxutils
import os
import json
import subprocess
import sys

sys.stdout.reconfigure(encoding='utf-8')

# Lấy danh sách tên sản phẩm qua artisan tinker
cmd = ['php', 'artisan', 'tinker', '--execute=echo json_encode(App\\Models\\Pesticide::orderBy("name")->pluck("name")->toArray(), JSON_UNESCAPED_UNICODE);']
res = subprocess.run(cmd, capture_output=True, text=True, encoding='utf-8')
output = res.stdout.strip()
product_names = json.loads(output)

print(f"Tổng số sản phẩm: {len(product_names)}")

# 1. Tạo file CSV UTF-8 with BOM (Excel mở trực tiếp không lỗi font)
csv_filename = "danh_sach_ten_san_pham.csv"
with open(csv_filename, "w", encoding="utf-8-sig", newline="") as f:
    f.write('"Tên sản phẩm"\n')
    for name in product_names:
        escaped_name = name.replace('"', '""')
        f.write(f'"{escaped_name}"\n')

print(f"Đã tạo: {csv_filename}")

# 2. Tạo file XLSX chuẩn Microsoft Excel (OpenXML Zip archive)
xlsx_filename = "danh_sach_ten_san_pham.xlsx"

# Build sheet1.xml
sheet_rows = []
# Header row
sheet_rows.append('<row r="1" spans="1:1"><c r="A1" t="s"><v>0</v></c></row>')

# Shared strings
shared_strings = ["Tên sản phẩm"]
for idx, name in enumerate(product_names, start=2):
    shared_strings.append(name)
    s_idx = len(shared_strings) - 1
    sheet_rows.append(f'<row r="{idx}" spans="1:1"><c r="A{idx}" t="s"><v>{s_idx}</v></c></row>')

sst_entries = "".join([f"<si><t>{saxutils.escape(s)}</t></si>" for s in shared_strings])
sst_xml = f'<?xml version="1.0" encoding="UTF-8" standalone="yes"?><sst xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" count="{len(shared_strings)}" uniqueCount="{len(shared_strings)}">{sst_entries}</sst>'

sheet_xml = f'''<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
    <cols>
        <col min="1" max="1" width="55" customWidth="1"/>
    </cols>
    <sheetData>
        {"".join(sheet_rows)}
    </sheetData>
</worksheet>'''

content_types_xml = '''<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
    <Default Extension="xml" ContentType="application/xml"/>
    <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
    <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
    <Override PartName="/xl/sharedStrings.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sharedStrings+xml"/>
    <Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>
</Types>'''

rels_xml = '''<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
</Relationships>'''

workbook_xml = '''<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
    <sheets>
        <sheet name="Danh sách sản phẩm" sheetId="1" r:id="rId1"/>
    </sheets>
</workbook>'''

workbook_rels_xml = '''<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
    <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
    <Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/sharedStrings" Target="sharedStrings.xml"/>
    <Relationship Id="rId3" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>
</Relationships>'''

styles_xml = '''<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
    <fonts count="1">
        <font><sz val="11"/><name val="Calibri"/></font>
    </fonts>
    <fills count="2">
        <fill><patternFill patternType="none"/></fill>
        <fill><patternFill patternType="gray125"/></fill>
    </fills>
    <borders count="1">
        <border><left/><right/><top/><bottom/></border>
    </borders>
    <cellStyleXfs count="1">
        <xf numFmtId="0" fontId="0" fillId="0" borderId="0"/>
    </cellStyleXfs>
    <cellXfs count="1">
        <xf numFmtId="0" fontId="0" fillId="0" borderId="0" xfId="0"/>
    </cellXfs>
</styleSheet>'''

with zipfile.ZipFile(xlsx_filename, 'w', zipfile.ZIP_DEFLATED) as z:
    z.writestr('[Content_Types].xml', content_types_xml)
    z.writestr('_rels/.rels', rels_xml)
    z.writestr('xl/workbook.xml', workbook_xml)
    z.writestr('xl/_rels/workbook.xml.rels', workbook_rels_xml)
    z.writestr('xl/worksheets/sheet1.xml', sheet_xml)
    z.writestr('xl/sharedStrings.xml', sst_xml)
    z.writestr('xl/styles.xml', styles_xml)

print(f"Đã tạo: {xlsx_filename}")

# Copy cả 2 file ra Desktop để người dùng mở ngay lập tức
desktop_path = r"C:\Users\ADMIN\Desktop"
if os.path.exists(desktop_path):
    import shutil
    shutil.copy(xlsx_filename, os.path.join(desktop_path, "danh_sach_ten_san_pham.xlsx"))
    shutil.copy(csv_filename, os.path.join(desktop_path, "danh_sach_ten_san_pham.csv"))
    print(f"Đã copy cả 2 file ra Desktop: {desktop_path}")
