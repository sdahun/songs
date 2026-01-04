package com.github.sdahun.songs;

import org.openlyrics.jlyrics.exception.LyricsException;
import org.openlyrics.jlyrics.hymnbook.Hymnbook;
import org.openlyrics.jlyrics.hymnbook.Hymnbooks;

import java.io.FileOutputStream;
import java.io.InputStream;
import java.nio.charset.StandardCharsets;
import java.nio.file.Files;
import java.nio.file.Paths;
import java.util.stream.Stream;

import static org.openlyrics.jlyrics.util.SongUtils.readAllBytes;

public class ReadmeGenerator {
    public static void main(String[] args) {
        new ReadmeGenerator().generate();
    }

    public void generate() {
        Hymnbooks books = new Hymnbooks();
        try (InputStream is = this.getClass().getClassLoader().getResourceAsStream("hymnbooks.json")) {
            if (is != null) {
                books.loadFromJson(is);
            }
        } catch (Exception e) {
            throw new RuntimeException();
        }

        StringBuilder sb = new StringBuilder();
        sb.append("# Énekeskönyvek\n\n")
            .append("A gyűjteményben szereplő énekeskönyvek feldolgozottsága és beszerzési lehetőségeinek linkjei:\n\n")
            .append("| Énekeskönyv | Feldolgozottság |\n")
            .append("| ----------- | --------------- |\n");

        long sum = 0;
        for (Hymnbook book: books) {
            try (InputStream is = this.getClass().getClassLoader().getResourceAsStream(book.getFolder() + "/")) {
                if (is != null) {
                    long count = Stream.of(new String(readAllBytes(is))
                        .split("\n"))
                        .count();

                    long low = (long) (book.getCount() * 0.3);
                    long high = (long) (book.getCount() * 0.7);

                    sb.append("| [")
                        .append(book.getName())
                        .append("](")
                        .append(book.getUrl())
                        .append(") | <meter value=\"")
                        .append(count)
                        .append("\" max=\"")
                        .append(book.getCount())
                        .append("\" optimum=\"")
                        .append(book.getCount())
                        .append("\" low=\"")
                        .append(low)
                        .append("\" high=\"")
                        .append(high)
                        .append("\"></meter> ")
                        .append((count*100) / book.getCount())
                        .append("% (")
                        .append(count)
                        .append("/")
                        .append(book.getCount())
                        .append(") |\n");

                    sum += count;
                }
            } catch (Exception e) {
                throw new RuntimeException(e);
            }
        }

        sb.append("\nA gyűjteményben jelenleg ")
            .append(sum)
            .append(" darab ének található.\n\n");

        String original;
        try (InputStream is = Files.newInputStream(Paths.get("README.md"))) {
            original = new String(readAllBytes(is), StandardCharsets.UTF_8);
        } catch (Exception e) {
            throw new RuntimeException(e.getMessage());
        }

        int fromPos = original.indexOf("# Énekeskönyvek");
        int untilPos = original.indexOf("# Támogatott szoftverek");

        StringBuilder content = new StringBuilder();
        content.append(original, 0, fromPos)
            .append(sb)
            .append(original, untilPos, original.length());

        try (FileOutputStream contentsFOS = new FileOutputStream("README.md")) {
            contentsFOS.write(content.toString().getBytes(StandardCharsets.UTF_8));
        } catch (Exception e) {
            throw new LyricsException(e.getMessage());
        }
    }
}
